<?php

namespace Itslearning;

use Itslearning\Client\ClientFactory;
use Itslearning\Client\SoapClientFactory;
use Itslearning\Exceptions\MessageTypeNotFoundException;
use Itslearning\Objects\Imses\Course;
use Itslearning\Objects\Imses\Person;
use Itslearning\Objects\Organisation\CalendarEvent;
use Itslearning\Objects\Organisation\CourseElementAssignment;
use Itslearning\Objects\Organisation\CourseElementFolder;
use Itslearning\Objects\Organisation\CourseElementPage;
use Itslearning\Objects\Organisation\CourseElementTest;
use Itslearning\Objects\Organisation\CoursePlanner;
use Itslearning\Objects\Organisation\ExtensionInstance;
use Itslearning\Objects\Organisation\MessageType;
use Itslearning\Objects\Organisation\MyFilesFile;
use Itslearning\Objects\Organisation\UploadFile;
use Itslearning\Objects\PaginatedResponse;
use Itslearning\Requests\Imses\CreateCourseRequest;
use Itslearning\Requests\Imses\ReadAllPersonsRequest;
use Itslearning\Requests\Imses\ReadPersonRequest;
use Itslearning\Requests\Imses\ReadPersonsRequest;
use Itslearning\Requests\Organisation\CreateCourseElementAssignmentRequest;
use Itslearning\Requests\Organisation\CreateCourseElementFolderRequest;
use Itslearning\Requests\Organisation\CreateCourseElementPageRequest;
use Itslearning\Requests\Organisation\CreateCourseElementTestRequest;
use Itslearning\Requests\Organisation\CreateCoursePlannerRequest;
use Itslearning\Requests\Organisation\CreateExtensionInstanceRequest;
use Itslearning\Requests\Organisation\CreateMyFilesFileRequest;
use Itslearning\Requests\Organisation\CreateOrUpdateCalendarEventRequest;
use Itslearning\Requests\Organisation\CreateOrUpdateCalendarEventsRequest;
use Itslearning\Requests\Organisation\DeleteCalendarEventRequest;
use Itslearning\Requests\Organisation\DeleteCalendarEventsRequest;
use Itslearning\Requests\Organisation\GetMessageTypesRequest;
use Itslearning\Requests\Organisation\ReadCoursesRequest;
use Itslearning\Requests\Organisation\UpdateExtensionInstanceRequest;
use Itslearning\Requests\Organisation\UploadFileRequest;

class Itslearning
{

    const PRODUCTION = 'production';
    const TESTING = 'testing';

    /**
     * @var ItslearningCredentials
     */
    private $credentials;

    /**
     * @var MessageType[]|null
     */
    private $messageTypes;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * Itslearning constructor.
     * @param ItslearningCredentials $credentials
     * @param ClientFactory $clientFactory
     */
    public function __construct(
        ItslearningCredentials $credentials,
        ClientFactory $clientFactory = null,
        string $env = null
    )
    {
        $this->credentials = $credentials;
        $this->env = $env === null ? self::PRODUCTION : $env;
        $this->clientFactory = $clientFactory === null ? new SoapClientFactory($env) : $clientFactory;
    }

    /**
     * Create a group of type course
     *
     * @link http://developer.itslearning.com/createGroup.html
     * @param Course $course
     * @return Course
     */
    public function createCourse(Course $course): Course
    {
        $client = $this->clientFactory->imses($this->credentials);

        $request = new CreateCourseRequest($course);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Create.Course.Element.Page.html
     * @param CourseElementPage $courseElementPage
     * @return CourseElementPage
     */
    public function createCourseElementPage(CourseElementPage $courseElementPage): CourseElementPage
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(CreateCourseElementPageRequest::CREATE_COURSE_ELEMENT_PAGE_MESSAGE_TYPE_NAME);
        $request = new CreateCourseElementPageRequest($courseElementPage, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Create.Course.Element.Folder.html
     * @param CourseElementFolder $courseElementFolder
     * @return CourseElementFolder
     */
    public function createCourseElementFolder(CourseElementFolder $courseElementFolder): CourseElementFolder
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(CreateCourseElementFolderRequest::CREATE_COURSE_ELEMENT_FOLDER_MESSAGE_TYPE_NAME);
        $request = new CreateCourseElementFolderRequest($courseElementFolder, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Create.Course.Element.Assignment.html
     * @param CourseElementAssignment $courseElementAssignment
     * @return CourseElementAssignment
     */
    public function createCourseElementAssignment(CourseElementAssignment $courseElementAssignment): CourseElementAssignment
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(CreateCourseElementAssignmentRequest::CREATE_COURSE_ELEMENT_ASSIGNMENT_MESSAGE_TYPE_NAME);
        $request = new CreateCourseElementAssignmentRequest($courseElementAssignment, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Create.Course.Element.Test.html
     * @param CourseElementTest $courseElementTest
     * @return CourseElementTest
     */
    public function createCourseElementTest(CourseElementTest $courseElementTest): CourseElementTest
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(CreateCourseElementTestRequest::CREATE_COURSE_ELEMENT_TEST_MESSAGE_TYPE_NAME);
        $request = new CreateCourseElementTestRequest($courseElementTest, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Create.Calendar.Event_and_Update.Calendar.Event.html
     * @param CalendarEvent $calendarEvent
     * @return CalendarEvent
     */
    public function createCalendarEvent(CalendarEvent $calendarEvent): CalendarEvent
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(CreateOrUpdateCalendarEventRequest::CREATE_CALENDAR_EVENT_MESSAGE_TYPE_NAME);
        $request = new CreateOrUpdateCalendarEventRequest($calendarEvent, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Create.Calendar.Event_and_Update.Calendar.Event.html
     * @param CalendarEvent[] $calendarEvent
     * @return CalendarEvent[]
     */
    public function createCalendarEvents(array $calendarEvents): array
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(CreateOrUpdateCalendarEventsRequest::CREATE_CALENDAR_EVENT_MESSAGE_TYPE_NAME);
        $request = new CreateOrUpdateCalendarEventsRequest($calendarEvents, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Create.Calendar.Event_and_Update.Calendar.Event.html
     * @param CalendarEvent $calendarEvent
     * @return CalendarEvent
     */
    public function updateCalendarEvent(CalendarEvent $calendarEvent)
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(CreateOrUpdateCalendarEventsRequest::UPDATE_CALENDAR_EVENT_MESSAGE_TYPE_NAME);
        $request = new CreateOrUpdateCalendarEventRequest($calendarEvent, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Create.Calendar.Event_and_Update.Calendar.Event.html
     * @param CalendarEvent[] $calendarEvents
     * @return CalendarEvent[]
     */
    public function updateCalendarEvents(array $calendarEvents)
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(CreateOrUpdateCalendarEventsRequest::UPDATE_CALENDAR_EVENT_MESSAGE_TYPE_NAME);
        $request = new CreateOrUpdateCalendarEventsRequest($calendarEvents, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Create.Course.Planner.html
     * @param CoursePlanner $coursePlanner
     * @return CoursePlanner
     */
    public function createCoursePlanner(CoursePlanner $coursePlanner): CoursePlanner
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(CreateCoursePlannerRequest::MESSAGE_TYPE_NAME);
        $request = new CreateCoursePlannerRequest($coursePlanner, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Create.Extension.Instance.html
     * @param ExtensionInstance $extensionInstance
     * @return ExtensionInstance
     */
    public function createExtension(ExtensionInstance $extensionInstance): ExtensionInstance
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(CreateExtensionInstanceRequest::MESSAGE_TYPE_NAME);
        $request = new CreateExtensionInstanceRequest($extensionInstance, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Update.Extension.Instance.html
     * @param ExtensionInstance $extensionInstance
     * @return ExtensionInstance
     */
    public function updateExtension(ExtensionInstance $extensionInstance): ExtensionInstance
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(UpdateExtensionInstanceRequest::MESSAGE_TYPE_NAME);
        $request = new UpdateExtensionInstanceRequest($extensionInstance, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Create.Course.File.html
     * @param MyFilesFile $myFilesFile
     * @return UploadFile
     */
    public function createMyFilesFile(MyFilesFile $myFilesFile): MyFilesFile
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(CreateMyFilesFileRequest::CREATE_MY_FILE_FILE_MESSAGE_TYPE_NAME);
        $request = new CreateMyFilesFileRequest($myFilesFile, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/DataService.svc_methods_and_messages.html
     * @return MessageType[]
     */
    public function getMessageTypes(): array
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $request = new GetMessageTypesRequest();

        return $request->execute($client);
    }

    /**
     * @param string $id
     * @return int
     * @throws MessageTypeNotFoundException
     */
    public function findMessageTypeIdentifierByName(string $name): int
    {
        if (empty($this->messageTypes)) {
            $this->messageTypes = $this->getMessageTypes();
        }

        foreach ($this->messageTypes as $type) {
            if ($type->getName() === $name) {
                return $type->getIdentifier();
            }
        }

        throw new MessageTypeNotFoundException('Message type "' . $name . '" not found');
    }

    /**
     * @link http://developer.itslearning.com/readAllPersons.html
     * @param int $pageIndex
     * @param int $pageSize
     * @param null $createdFrom
     * @param bool $onlyManuallyCreatedUsers
     * @param bool $convertFromManual
     * @return PaginatedResponse
     */
    public function readAllPersons(
        int $pageIndex = 1,
        int $pageSize = 1,
        $createdFrom = null,
        bool $onlyManuallyCreatedUsers = false,
        bool $convertFromManual = false
    ): PaginatedResponse
    {
        $client = $this->clientFactory->imses($this->credentials);

        $request = new ReadAllPersonsRequest(
            $pageIndex,
            $pageSize,
            $createdFrom,
            $onlyManuallyCreatedUsers,
            $convertFromManual
        );

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/readPerson.html
     * @param string $syncID
     * @return Person
     */
    public function readPerson(string $syncID): Person
    {
        $client = $this->clientFactory->imses($this->credentials);

        $request = new ReadPersonRequest($syncID);

        return $request->execute($client);
    }

    /**
     * @param $syncIDs
     * @return Person[]
     */
    public function readPersons($syncIDs): array
    {
        $client = $this->clientFactory->imses($this->credentials);

        $request = new ReadPersonsRequest($syncIDs);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Read.Courses.html
     * @return PaginatedResponse
     */
    public function readCourses(int $pageIndex = 0, int $pageSize = 1000)
    {
        $client = $this->clientFactory->organisationReadData($this->credentials);

        $request = new ReadCoursesRequest($pageIndex, $pageSize);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Delete.Calendar.Event.html
     * @param string $syncID
     * @return bool
     */
    public function deleteCalendarEvent(string $syncID)
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(DeleteCalendarEventRequest::MESSAGE_TYPE_NAME);

        $request = new DeleteCalendarEventRequest($syncID, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Delete.Calendar.Event.html
     * @param array $syncIDs
     * @return bool
     */
    public function deleteCalendarEvents(array $syncIDs)
    {
        $client = $this->clientFactory->organisationData($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(DeleteCalendarEventsRequest::MESSAGE_TYPE_NAME);
        $request = new DeleteCalendarEventsRequest($syncIDs, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/FileService.svc_methods_and_messages.html
     * @param UploadFile $uploadFile
     * @return UploadFile
     */
    public function uploadFile(UploadFile $uploadFile): UploadFile
    {
        $client = $this->clientFactory->organisationFile($this->credentials);

        $request = new UploadFileRequest($uploadFile);

        return $request->execute($client);
    }


}
