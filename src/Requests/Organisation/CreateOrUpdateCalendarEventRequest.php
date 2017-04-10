<?php


namespace Itslearning\Requests\Organisation;

use Itslearning\Client\ItslearningClient;
use Itslearning\Objects\Organisation\CalendarEvent;
use Itslearning\Requests\Request;

class CreateOrUpdateCalendarEventRequest implements Request
{

    const CREATE_CALENDAR_EVENT_MESSAGE_TYPE_NAME = 'Create.Calendar.Event';
    const UPDATE_CALENDAR_EVENT_MESSAGE_TYPE_NAME = 'Update.Calendar.Event';
    /**
     * @var CalendarEvent
     */
    private $calendarEvent;
    /**
     * @var int
     */
    private $messageTypeIdentifier;

    /**
     * @param CalendarEvent $calendarEvent
     * @param int $messageTypeIdentifier
     */
    public function __construct(CalendarEvent $calendarEvent, int $messageTypeIdentifier)
    {
        $this->calendarEvent = $calendarEvent;
        $this->messageTypeIdentifier = $messageTypeIdentifier;
    }

    /**
     * @param ItslearningClient $client
     * @return CalendarEvent
     */
    public function execute(ItslearningClient $client)
    {
        $data = $this->map($this->calendarEvent);

        $result = $client->message($this->messageTypeIdentifier, $data);

        return $this->transform($result);
    }

    private function map(CalendarEvent $calendarEvent)
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
        $event['SyncKeyRef'] = 'ID1';
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

        $data = [
            'Message' => [
                'xmlns:' => 'urn:message-schema',
                'SyncKeys' => [
                    'SyncKey' => [
                        [
                            '@ID' => $event['SyncKeyRef'],
                            '@' => $calendarEvent->getSyncKey()
                        ]
                    ]
                ],
                'Events' => [
                    'Event' => [
                        $event
                    ]
                ]
            ]
        ];

        return $data;
    }

    private function transform($result): CalendarEvent
    {
        if (isset($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey)) {
            $this->calendarEvent->setSyncKey($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey);
        }

        return $this->calendarEvent;
    }
}