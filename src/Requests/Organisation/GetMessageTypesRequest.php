<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Exceptions\RequestException;
use Itslearning\Objects\Organisation\MessageType;
use Itslearning\Requests\Request;

class GetMessageTypesRequest implements Request
{
    const METHOD = 'GetMessageTypes';

    /**
     * @param ItslearningClient $client
     * @return mixed
     */
    public function execute(ItslearningClient $client)
    {
        $arguments = [];
        $result = $client->call(self::METHOD, $arguments);

        if (
            !isset($result->GetMessageTypesResult->DataMessageType)
            || !is_array($result->GetMessageTypesResult->DataMessageType)
        ) {
            throw new RequestException('Invalid response for GetMessageTypes request');
        }

        $messageTypesData = $result->GetMessageTypesResult->DataMessageType;

        $result = $this->transform($messageTypesData);

        return $result;
    }

    /**
     * @param $messageTypesData
     * @return array
     */
    protected function transform($messageTypesData):array
    {
        $result = [];
        foreach ($messageTypesData as $messageTypeData) {
            $messageType = new MessageType();
            $messageType->setIdentifier($messageTypeData->Identifier);
            $messageType->setName($messageTypeData->Name);

            $result[] = $messageType;
        }

        return $result;
    }
}