<?php


namespace Itslearning\Requests\Organisation;

use Itslearning\Client\ItslearningClient;
use Itslearning\Requests\Request;

class DeleteCalendarEventRequest implements Request
{

    const MESSAGE_TYPE_NAME = 'Delete.Calendar.Event';

    /**
     * @var string syncID
     */
    private $syncID;
    /**
     * @var int
     */
    private $messageTypeIdentifier;

    /**
     * @param string $syncID
     * @param int $messageTypeIdentifier
     */
    public function __construct(string $syncID, int $messageTypeIdentifier)
    {
        $this->syncID = $syncID;
        $this->messageTypeIdentifier = $messageTypeIdentifier;
    }

    /**
     * @param ItslearningClient $client
     * @return bool
     */
    public function execute(ItslearningClient $client)
    {
        $data = $this->map($this->syncID);

        $result = $client->message($this->messageTypeIdentifier, $data);

        $this->transform($result);
        return true;
    }

    private function map(string $syncID)
    {
        $data = [
            'Message' => [
                'xmlns:' => 'urn:message-schema',
                'SyncKeys' => [
                    'SyncKey' => [$syncID]
                ],
            ]
        ];

        return $data;
    }

    /**
     * @return void
     * @throws
     * @param $result
     */
    private function transform($result): void
    {
        return;
    }
}