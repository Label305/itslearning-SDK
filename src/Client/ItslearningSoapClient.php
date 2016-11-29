<?php


namespace Itslearning\Client;


use Itslearning\Exceptions\ItslearningException;
use Itslearning\Exceptions\RequestException;
use Itslearning\Exceptions\TimeoutException;
use Itslearning\Util\XmlHelper;

class ItslearningSoapClient extends \SoapClient implements ItslearningClient
{
    const STATUS_INQUEUE = 'InQueue';

    const CODE_MAJOR_FAILURE = 'failure';

    const MESSAGE_STATUS_TYPE_ERROR = 'Error';

    /**
     * Timeout after which the request will abort
     */
    const TIMEOUT = 60000;

    /**
     * @param string $method
     * @param array  $arguments
     */
    public function call(string $method, array $arguments)
    {
        return $this->__soapCall($method, $arguments);
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
     * @param string $function_name
     * @param array  $arguments
     * @param null   $options
     * @param null   $input_headers
     * @param null   $output_headers
     * @return mixed
     * @throws RequestException
     */
    public function __soapCall(
        $function_name,
        $arguments,
        $options = null,
        $input_headers = null,
        &$output_headers = null
    ) {
        try {
            $result = parent::__soapCall(
                $function_name,
                $arguments,
                $options,
                $input_headers,
                $output_headers
            );

            $this->throwErrors($output_headers);

            return $result;
        } catch (\SoapFault $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        }
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

            $status = $this->__soapCall(
                'GetMessageResult',
                [
                    [
                        'messageId' => $result->AddMessageResult->MessageId
                    ]
                ]
            );
            if (
                $status->GetMessageResultResult->Status != self::STATUS_INQUEUE
                && isset($status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->Type)
                && $status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->Type == self::MESSAGE_STATUS_TYPE_ERROR
            ) {
                throw new RequestException('Error from queued AddMessage request: ' . $status->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->Message);
            }

        } while ($status->GetMessageResultResult->Status == self::STATUS_INQUEUE);

        return $status;
    }

}