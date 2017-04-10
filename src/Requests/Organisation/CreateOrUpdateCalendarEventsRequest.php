<?php


namespace Itslearning\Requests\Organisation;

use Illuminate\Support\Facades\Log;
use Itslearning\Client\ItslearningClient;
use Itslearning\Objects\Organisation\CalendarEvent;
use Itslearning\Requests\Request;

class CreateOrUpdateCalendarEventsRequest implements Request
{

    const CREATE_CALENDAR_EVENT_MESSAGE_TYPE_NAME = 'Create.Calendar.Event';
    const UPDATE_CALENDAR_EVENT_MESSAGE_TYPE_NAME = 'Update.Calendar.Event';
    /**
     * @var CalendarEvent[]
     */
    private $calendarEvents;
    /**
     * @var int
     */
    private $messageTypeIdentifier;

    /**
     * @param CalendarEvent[] $calendarEvents
     * @param int $messageTypeIdentifier
     */
    public function __construct(array $calendarEvents, int $messageTypeIdentifier)
    {
        $this->calendarEvents = $calendarEvents;
        $this->messageTypeIdentifier = $messageTypeIdentifier;
    }

    /**
     * @param ItslearningClient $client
     * @return CalendarEvent[]
     */
    public function execute(ItslearningClient $client)
    {
        $data = $this->map($this->calendarEvents);

        $client->message($this->messageTypeIdentifier, $data);

        return $this->calendarEvents;
    }

    private function map(array $calendarEvents)
    {
        $events = [];
        $syncKeys = [];
        foreach ($calendarEvents as $key => $calendarEvent) {
            $syncKeyRef = 'ID' . ($key + 1);
            $events[] = $this->mapSingleEvent($calendarEvent, $syncKeyRef);
            $syncKeys[] = [
                '@ID' => $syncKeyRef,
                '@' => $calendarEvent->getSyncKey()
            ];
        }


        $data = [
            'Message' => [
                'xmlns:' => 'urn:message-schema',
                'SyncKeys' => [
                    'SyncKey' => $syncKeys
                ],
                'Events' => [
                    'Event' => $events
                ]
            ]
        ];

        return $data;
    }

    private function mapSingleEvent(CalendarEvent $calendarEvent, string $syncKeyRef): array
    {

        $event = [];

        if ($calendarEvent->getSiteId() !== null) {
            $event['SiteId'] = $calendarEvent->getSiteId();
        }
        if ($calendarEvent->getVendorId() !== null) {
            $event['VendorId'] = $calendarEvent->getVendorId();
        }
        if ($calendarEvent->getStartDateTime() !== null) {
            $event['StartDateTime'] = $calendarEvent->getStartDateTime()->format('c');
        }
        if ($calendarEvent->getEndDateTime() !== null) {
            $event['EndDateTime'] = $calendarEvent->getEndDateTime()->format('c');
        }
        if ($calendarEvent->getDescription() !== null) {
            $event['Description'] = $calendarEvent->getDescription();
        }
        $event['SyncKeyRef'] = $syncKeyRef;
        if ($calendarEvent->isLesson() !== null) {
            $event['IsLesson'] = $calendarEvent->isLesson();
        }
        if ($calendarEvent->getUserId() !== null) {
            $event['UserId'] = $calendarEvent->getUserId();
        }
        if ($calendarEvent->getUserSyncKey() !== null) {
            $event['UserSyncKey'] = $calendarEvent->getUserSyncKey();
        }
        if ($calendarEvent->getCourseId() !== null) {
            $event['CourseId'] = $calendarEvent->getCourseId();
        }
        if ($calendarEvent->getCourseSyncKey() !== null) {
            $event['CourseSyncKey'] = $calendarEvent->getCourseSyncKey();
        }
        if ($calendarEvent->getGroupHierarchyId() !== null) {
            $event['GroupHierarchyId'] = $calendarEvent->getGroupHierarchyId();
        }
        if ($calendarEvent->getGroupHierarchySyncKey() !== null) {
            $event['GroupHierarchySyncKey'] = $calendarEvent->getGroupHierarchySyncKey();
        }

        return $event;
    }
}