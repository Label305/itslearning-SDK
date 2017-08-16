<?php


namespace Itslearning\Client;


use Itslearning\Exceptions\ItslearningException;
use Itslearning\Exceptions\RequestException;
use Itslearning\Exceptions\TimeoutException;
use Itslearning\Util\XmlHelper;

class ItslearningSoapClient implements ItslearningClient
{
    const STATUS_INQUEUE = 'InQueue';
    const STATUS_FINISHED = 'Finished';

    const CODE_MAJOR_FAILURE = 'failure';

    const MESSAGE_STATUS_TYPE_INFO = 'Info';
    const MESSAGE_STATUS_TYPE_ERROR = 'Error';
    const RAW_XML_PLACEHOLDER_PREFIX = 'ITSLEARNINGXMLPLACHOLDER';


    /**
     * Timeout after which the request will abort
     */
    const TIMEOUT = 60000;
    /**
     * @var \SoapClient
     */
    private $soapClient;

    /**
     * ItslearningSoapClient constructor.
     * @param \SoapClient $soapClient
     */
    public function __construct(\SoapClient $soapClient)
    {
        $this->soapClient = $soapClient;
    }

    /**
     * @param string $method
     * @param array $arguments
     */
    public function call(string $method, array $arguments, SoapFaultHandler $soapFaultHandler = null)
    {
        try {
            $result = $this->soapClient->__soapCall($method, $arguments, null, null, $output_headers);

            $this->throwErrors($output_headers);

            return $result;
        } catch (\SoapFault $e) {
            if ($soapFaultHandler !== null) {
                return $soapFaultHandler->handleSoapFault($e, $this->soapClient);
            } else {
                throw new RequestException($e->getMessage(), $e->getCode(), $e);
            }
        }
    }

    /**
     * @param string $type
     * @param array $data
     * @throws ItslearningException
     */
    public function message(string $type, array $data)
    {
        $placeholders = $this->extractRawPlaceholders($data);

        $dom = XmlHelper::fromArray($data);
        $dataXml = $dom->saveXML();

        $arguments = [
            'dataMessage' => [
                'Data' => $this->injectRaw($placeholders, $dataXml),
                'Type' => $type
            ]
        ];

        $result = $this->call('AddMessage', [$arguments]);

        return $this->fetchResultForQueuedRequest($result);
    }

    /**
     * @param $output_headers
     * @throws RequestException
     */
    private function throwErrors(&$output_headers)
    {
        if (
            isset($output_headers['syncResponseHeaderInfo']->statusInfo->codeMajor)
            && $output_headers['syncResponseHeaderInfo']->statusInfo->codeMajor == self::CODE_MAJOR_FAILURE
        ) {
            throw new RequestException(
                'SOAP error: ' . $output_headers['syncResponseHeaderInfo']->statusInfo->description->text,
                500
            );
        }
    }

    /**
     * @param $result
     * @throws RequestException
     */
    private function fetchResultForQueuedRequest($result)
    {
        if (!isset($result->AddMessageResult->MessageId)) {
            throw new RequestException('No MessageId in response');
        }

        $start = microtime(true);

        /* Exponential back-off implementation */
        $delay = 100;
        do {
            if ((microtime(true) - $start) * 1000 > self::TIMEOUT) {
                throw new TimeoutException('Request timed out');
            }

            usleep($delay);
            $delay *= 2;

            $status = $this->call(
                'GetMessageResult',
                [
                    [
                        'messageId' => $result->AddMessageResult->MessageId
                    ]
                ]
            );
            if (
                !isset($status->GetMessageResultResult->Status)
                || (
                    $status->GetMessageResultResult->Status != self::STATUS_INQUEUE
                    && $this->messageResultHasError($status)
                )
            ) {
                if (isset($status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->Message)) {
                    $str = 'Error from queued AddMessage request: ' . $status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->Message;
                } else if (isset($status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail[0]->Message)) {
                    $str = 'Error from queued AddMessage request: ' . $status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail[0]->Message;
                } else {
                    $str = 'An error occured from queued AddMessage request without DataMessageStatusDetail';
                }
                throw new RequestException($str);
            }

        } while ($status->GetMessageResultResult->Status == self::STATUS_INQUEUE);

        return $status;
    }

    private function messageResultHasError($status)
    {
        if (isset($status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail)) {
            if (!is_array($status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail)) {
                return $status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->Type == self::MESSAGE_STATUS_TYPE_ERROR;
            } else {
                foreach ($status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail as $dataMessageStatusDetail) {
                    if ($dataMessageStatusDetail->Type == self::MESSAGE_STATUS_TYPE_ERROR) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Extracts all parts that should've been kept as raw xml
     * @param $data
     * @return array
     */
    private function extractRawPlaceholders(array &$data, &$index = 1): array
    {
        $placeholders = [];
        foreach ($data as $key => &$value) {
            if (
                is_string($value)
                && strpos($value, '<![XML[') === 0
                && substr($value, -strlen(']]>')) === ']]>'
            ) {
                $placeholderValue = substr($value, strlen('<![XML['), strlen($value) - strlen('<![XML[]]>'));
                $identifier = self::RAW_XML_PLACEHOLDER_PREFIX . $index;
                $index++;
                $placeholders[$identifier] = $placeholderValue;
                $data[$key] = $identifier;
            } elseif (is_array($value)) {
                $placeholders = array_merge($this->extractRawPlaceholders($value, $index));
            }
        }

        return $placeholders;
    }

    /**
     * Re-injects parts that should have been kept as raw content,
     * @param array $placeholders
     * @param string $xml
     * @return string
     */
    private function injectRaw(array $placeholders, string $xml): string
    {
        foreach ($placeholders as $identifier => $value) {
            $xml = str_replace($identifier, $value, $xml);
        }
        return $xml;
    }

}