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
     * @param array  $arguments
     */
    public function call(string $method, array $arguments)
    {
        try {
            $result = $this->soapClient->__soapCall($method, $arguments);

            $this->throwErrors($output_headers);

            return $result;
        } catch (\SoapFault $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $type
     * @param array  $data
     * @throws ItslearningException
     */
    public function message(string $type, array $data)
    {
        $dom = XmlHelper::fromArray($data);

        $arguments = [
            'dataMessage' => [
                'Data' => $dom->saveXML(),
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
                    && isset($status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->Type)
                    && $status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->Type == self::MESSAGE_STATUS_TYPE_ERROR
                )
            ) {
                if (isset($status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->Message)) {
                    $str = 'Error from queued AddMessage request: ' . $status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->Message;
                } else {
                    $str = 'An error occured from queued AddMessage request without DataMessageStatusDetail';
                }
                throw new RequestException($str);
            }

        } while ($status->GetMessageResultResult->Status == self::STATUS_INQUEUE);

        return $status;
    }

}