<?php


namespace Itslearning\Requests\Organisation;

use Itslearning\Client\ItslearningClient;
use Itslearning\Objects\Organisation\CalendarEvent;
use Itslearning\Requests\Request;

class DeleteCalendarEventsRequest implements Request
{

    const MESSAGE_TYPE_NAME = 'Delete.Calendar.Event';

    /**
     * @var string syncID
     */
    private $syncIDs;
    /**
     * @var int
     */
    private $messageTypeIdentifier;

    /**
     * @param array $syncIDs
     * @param int $messageTypeIdentifier
     */
    public function __construct(array $syncIDs, int $messageTypeIdentifier)
    {
        $this->syncIDs = $syncIDs;
        $this->messageTypeIdentifier = $messageTypeIdentifier;
    }

    /**
     * @param ItslearningClient $client
     * @return bool
     */
    public function execute(ItslearningClient $client)
    {
        $data = $this->map($this->syncIDs);

        $result = $client->message($this->messageTypeIdentifier, $data);

        return $this->transform($result);
    }

    private function map(array $syncIDs)
    {
        $data = [
            'Message' => [
                'xmlns:' => 'urn:message-schema',
                'SyncKeys' => [
                    'SyncKey' => $syncIDs
                ],
            ]
        ];

        return $data;
    }

    private function transform($result): void
    {
        return;
    }
}