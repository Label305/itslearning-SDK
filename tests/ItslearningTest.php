<?php


namespace Tests;


use Itslearning\Exceptions\ItslearningException;
use Itslearning\Objects\Imses\Course;
use Itslearning\Objects\Organisation\CalendarEvent;
use Itslearning\Objects\Organisation\Column;
use Itslearning\Objects\Organisation\ContentBlockSet;
use Itslearning\Objects\Organisation\CourseElementFolder;
use Itslearning\Objects\Organisation\CourseElementPage;
use Itslearning\Objects\Organisation\CourseElementTest;
use Itslearning\Objects\Organisation\CoursePlanner;
use Itslearning\Objects\Organisation\CustomColumnData;
use Itslearning\Objects\Organisation\ExtensionInstance;
use Itslearning\Objects\Organisation\ExtensionInstanceLTIContent;
use Itslearning\Objects\Organisation\File;
use Itslearning\Objects\Organisation\Lesson;
use Itslearning\Objects\Organisation\MyFilesFile;
use Itslearning\Objects\Organisation\PageContent;
use Itslearning\Objects\Organisation\TextContentBlock;
use Itslearning\Objects\Organisation\Topic;
use Itslearning\Objects\Organisation\UploadFile;

class ItslearningTest extends TestCase
{

    public function testGetMessageTypeIdentifier()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        /* When */
        $result = $itslearning->findMessageTypeIdentifierByName('Update.Extension.Instance');

        /* Then */
        $this->assertEquals(54, $result);
    }


    public function testCreateCalendarEvent()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        $calendarEvent = new CalendarEvent();
        $calendarEvent->setSyncKey('personal-' . time());
        $calendarEvent->setStartDateTime(new \DateTime());
        $calendarEvent->setEndDateTime(new \DateTime('+1 hour'));
        $calendarEvent->setUserSyncKey('798951');

        /* When */
        $itslearning->createCalendarEvent($calendarEvent);

        /* Then */
        //plz no crash
    }

    public function testCreateCalendarEvents()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        $calendarEvent1 = new CalendarEvent();
        $calendarEvent1->setSyncKey('personal-2-' . time());
        $calendarEvent1->setStartDateTime(new \DateTime());
        $calendarEvent1->setEndDateTime(new \DateTime('+1 hour'));
        $calendarEvent1->setUserSyncKey('798951');

        $calendarEvent2 = new CalendarEvent();
        $calendarEvent2->setSyncKey('personal-1-' . time());
        $calendarEvent2->setStartDateTime(new \DateTime('+1 hour'));
        $calendarEvent2->setEndDateTime(new \DateTime('+2 hours'));
        $calendarEvent2->setUserSyncKey('798951');

        /* When */
        $itslearning->createCalendarEvents([
            $calendarEvent1,
            $calendarEvent2
        ]);

        /* Then */
        //plz no crash
    }

    public function testDeleteCalendarEvent()
    {
        $this->skipInCi();
        /* Given */
        $itslearning = $this->getInstance();

        $calendarEvent = new CalendarEvent();
        $calendarEvent->setSyncKey('personal-' . time());
        $calendarEvent->setStartDateTime(new \DateTime());
        $calendarEvent->setEndDateTime(new \DateTime('+1 hour'));
        $calendarEvent->setUserSyncKey('798951');
        $itslearning->createCalendarEvent($calendarEvent);

        /* When */
        $itslearning->deleteCalendarEvent($calendarEvent->getSyncKey());
        $itslearning->deleteCalendarEvent($calendarEvent->getSyncKey());

        /* Then */
        //plz No crash
    }

    public function testDeleteCalendarEvents()
    {
        $this->skipInCi();
        /* Given */
        $itslearning = $this->getInstance();

        $calendarEvent = new CalendarEvent();
        $calendarEvent->setSyncKey('personal-' . time());
        $calendarEvent->setStartDateTime(new \DateTime());
        $calendarEvent->setEndDateTime(new \DateTime('+1 hour'));
        $calendarEvent->setUserSyncKey('798951');

        $calendarEvent2 = new CalendarEvent();
        $calendarEvent2->setSyncKey('personal-1-' . time());
        $calendarEvent2->setStartDateTime(new \DateTime('+1 hour'));
        $calendarEvent2->setEndDateTime(new \DateTime('+2 hours'));
        $calendarEvent2->setUserSyncKey('798951');

        $itslearning->createCalendarEvents([$calendarEvent, $calendarEvent2]);

        /* When */
        $itslearning->deleteCalendarEvents([$calendarEvent->getSyncKey(), $calendarEvent2->getSyncKey()]);

        /* Then */
        //plz No crash
    }

    public function testCreateCourse()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        $course = new Course();
        $course->setTitle(date('Y-m-d H:i:s') . ' - SDKTest test');
        $course->setShortDescription('SDKTest course');
        $course->setParentSyncKey($this->getHierarchySyncKey());
        $course->setSyncKey('SDKTEST' . date('YmdHis'));
        $course->setUserSyncKey($this->getUserSyncKey());

        /* When */
        $itslearning->createCourse($course);

        /* Then */
        //plz no crash
    }

    public function testCreateCourseElementPage()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        $courseElementPage = new CourseElementPage();
        $courseElementPage->setSyncKey('SDKTEST' . date('YmdHis'));
        $courseElementPage->setCourseSyncKey(getenv('COURSE_SYNC_KEY'));
        $courseElementPage->setUserSyncKey(getenv('USER_SYNC_KEY'));
        $courseElementPage->setTitle('Howdy');
        $pageContent = new PageContent();
        $contentBlockSet = new ContentBlockSet();
        $textContentBlock = new TextContentBlock();
        $textContentBlock->setTitle('Test text content block');
        $textContentBlock->setText('<p>Content of my test text content block</p>');
        $contentBlockSet->setContentBlock($textContentBlock);
        $contentBlockSet->setFileContents([]);
        $pageContent->setContentBlockSets([$contentBlockSet]);
        $courseElementPage->setContent($pageContent);

        /* When */
        $itslearning->createCourseElementPage($courseElementPage);
    }

    public function testCreateCourseElementFolder()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        $courseElementFolder = new CourseElementFolder();
        $courseElementFolder->setSyncKey('SDKTEST' . date('YmdHis'));
        $courseElementFolder->setCourseSyncKey(getenv('COURSE_SYNC_KEY'));
        $courseElementFolder->setUserSyncKey(getenv('USER_SYNC_KEY'));
        $courseElementFolder->setTitle('Howdy');
        $courseElementFolder->setSecurity(CourseElementFolder::SECURITY_INHERIT);

        /* When */
        $itslearning->createCourseElementFolder($courseElementFolder);
    }

    public function testCreateCourseElementTest()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        $uploadedFile = new UploadFile();
        $uploadedFile->setName('test.zip');
        $uploadedFile->setContent(file_get_contents(__DIR__ . '/Resources/qti.zip'));
        $itslearning->uploadFile($uploadedFile);

        $courseElementTest = new CourseElementTest();
        $courseElementTest->setCourseSyncKey(getenv('COURSE_SYNC_KEY'));
        $courseElementTest->setUserSyncKey(getenv('USER_SYNC_KEY'));
        $courseElementTest->setTitle('Some awesome test');
        $courseElementTest->setFiles([$uploadedFile->getSyncKey()]);

        /* When */
        $itslearning->createCourseElementTest($courseElementTest);

        var_dump($courseElementTest->getSyncKey());
    }


    public function testCreateExtension()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        $extensionInstance = new ExtensionInstance();
        $extensionInstance->setSyncKey('SDKTEST' . time());
        $extensionInstance->setLocation('Library');
        $extensionInstance->setExtensionId(5003);
        $extensionInstance->setCourseSyncKey($this->getCourseSyncKey());
        $extensionInstance->setUserSyncKey($this->getUserSyncKey());
        $extensionInstance->setTitle('Sdk - TEST');
        $extensionInstanceLTIContent = new ExtensionInstanceLTIContent();

        $xml = <<<XML
<lti:cartridge_basiclti_link xmlns:lti="http://www.imsglobal.org/xsd/imslticc_v1p0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:blti="http://www.imsglobal.org/xsd/imsbasiclti_v1p0" xmlns:lticp="http://www.imsglobal.org/xsd/imslticp_v1p0" xsi:schemaLocation="http://www.imsglobal.org/xsd/imsccv1p1/imscp_v1p1 http://www.imsglobal.org/profile/cc/ccv1p1/ccv1p1_imscp_v1p2_v1p0.xsd http://ltsc.ieee.org/xsd/imsccv1p1/LOM/manifest http://www.imsglobal.org/profile/cc/ccv1p1/LOM/ccv1p1_lommanifest_v1p0.xsd http://www.imsglobal.org/xsd/imslticc_v1p0 http://www.imsglobal.org/xsd/lti/ltiv1p0/imslticc_v1p0.xsd http://www.imsglobal.org/xsd/imsbasiclti_v1p0 http://www.imsglobal.org/xsd/lti/ltiv1p0/imsbasiclti_v1p0p1.xsd http://www.imsglobal.org/xsd/imslticm_v1p0 http://www.imsglobal.org/xsd/lti/ltiv1p0/imslticm_v1p0.xsd http://www.imsglobal.org/xsd/imslticp_v1p0 http://www.imsglobal.org/xsd/lti/ltiv1p0/imslticp_v1p0.xsd">
  <blti:title xmlns:blti="http://www.imsglobal.org/xsd/imsbasiclti_v1p0">Voedingsstoffen en voedingsmiddelen</blti:title>
  <blti:launch_url xmlns:blti="http://www.imsglobal.org/xsd/imsbasiclti_v1p0">http://maken.wikiwijs.nl/lti/questionnaire/2307876</blti:launch_url>
  <blti:secure_launch_url xmlns:blti="http://www.imsglobal.org/xsd/imsbasiclti_v1p0">https://maken.wikiwijs.nl/lti/questionnaire/2307876</blti:secure_launch_url>
  <blti:icon xmlns:blti="http://www.imsglobal.org/xsd/imsbasiclti_v1p0">http://maken.wikiwijs.nl//favicon.ico</blti:icon>
  <blti:secure_icon xmlns:blti="http://www.imsglobal.org/xsd/imsbasiclti_v1p0">https://maken.wikiwijs.nl//favicon.ico</blti:secure_icon>
  <blti:vendor xmlns:blti="http://www.imsglobal.org/xsd/imsbasiclti_v1p0">
    <lticp:code xmlns:lticp="http://www.imsglobal.org/xsd/imslticp_v1p0">Wikiwijs</lticp:code>
    <lticp:name xmlns:lticp="http://www.imsglobal.org/xsd/imslticp_v1p0">Wikiwijs</lticp:name>
  </blti:vendor>
</lti:cartridge_basiclti_link>
XML;
        $extensionInstanceLTIContent->setXmlConfigurationXml(trim($xml));
        $extensionInstance->setContent($extensionInstanceLTIContent);

        /* When */
        $itslearning->createExtension($extensionInstance);
        /* Then */
        //plz no crash
    }

    public function testReadAllPersons()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        /* When */
        $persons = $itslearning->readAllPersons(1, 10);

        /* Then */
        $this->assertCount(10, $persons->getData());
    }

    public function testReadPerson()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        /* When */
        $person = $itslearning->readPerson($this->getOtherUserSyncKey());

        /* Then */
        $this->assertNotNull($person->getName()->getFirst());
    }

    public function testReadPersons()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        /* When */
        $persons = $itslearning->readPersons([
            $this->getUserSyncKey(),
            $this->getOtherUserSyncKey()
        ]);

        /* Then */
        $this->assertCount(2, $persons);
    }

    public function testReadCourses()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        /* When */
        $result = $itslearning->readCourses(0, 3);

        /* Then */
        $data = $result->getData();
        $this->assertCount(3, $data);
        $this->assertInstanceOf(Course::class, $data[0]);
    }

    public function testCreateCoursePlanner()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        $courseSyncKey = 'SDKTEST' . date('YmdHis');
        try {
            $course = new Course();
            $course->setTitle(date('Y-m-d H:i:s') . ' - SDKTest test');
            $course->setShortDescription('SDKTest course' . date('YmdHis'));
            $course->setParentSyncKey($this->getHierarchySyncKey());
            $course->setSyncKey($courseSyncKey);
            $course->setUserSyncKey($this->getUserSyncKey());
            $itslearning->createCourse($course);
        } catch (ItslearningException $e) {
            $this->assertTrue(false, 'Error creating a course before even trying to create a course planner');
        }

        $coursePlanner = new CoursePlanner();
        $coursePlanner->setCourseSyncKey($courseSyncKey);
        $coursePlanner->setUserSyncKey($this->getUserSyncKey());
        $coursePlanner->setSyncKey('SDKTEST' . date('YmdHis'));

        $topicColumns = [];
        $column = new Column();
        $column->setColumnId(1337);
        $column->setName('First topic column');
        $column->setType(Column::TYPE_CUSTOM);
        $topicColumns[] = $column;
        $coursePlanner->setTopicColumns($topicColumns);

        $lessonColumns = [];
        $column = new Column();
        $column->setColumnId(1620);
        $column->setName('First lesson column');
        $column->setType(Column::TYPE_CUSTOM);
        $lessonColumns[] = $column;
        $coursePlanner->setLessonColumns($lessonColumns);

        $topic = new Topic();
        $topic->setName('Hello topic');
        $customColumnsData = [];
        $customColumnData = new CustomColumnData();
        $customColumnData->setColumnId(1337);
        $customColumnData->setText('1337 column');
        $topic->setCustomColumnsData($customColumnsData);

        $lesson = new Lesson();
        $lesson->setName('My lesson');
        $customColumnsData = [];
        $customColumnData = new CustomColumnData();
        $customColumnData->setColumnId(1620);
        $customColumnData->setText('1620 column');
        $customColumnsData[] = $customColumnData;
        $lesson->setCustomColumnsData($customColumnsData);

        $lessons[] = $lesson;
        $topic->setLessons($lessons);

        /* Learning objectives */
        /* TODO: check these when there's need for it, they are rarely used by automated systems */
//        $learningObjectives = [];
//        $learningObjective = new LearningObjective();
//        $learningObjective->setColumndId(1337);
//        $learningObjective->setLearningObjectiveId(1);
//        $learningObjectives[] = $learningObjective;
//        $learningObjective = new LearningObjective();
//        $learningObjective->setColumndId(1620);
//        $learningObjective->setLearningObjectiveId(2);
//        $learningObjectives[] = $learningObjective;
//        $topic->setLearningObjectives($learningObjectives);

        $coursePlanner->setTopics([$topic]);

        /* When */
        $result = $itslearning->createCoursePlanner($coursePlanner);
    }

    public function testUploadFile()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        $uploadFile = new UploadFile();
        $uploadFile->setName('itslearning_logo.png');
        $uploadFile->setContent(file_get_contents(__DIR__ . '/Resources/itslearning_logo.png'));

        /* When */
        $itslearning->uploadFile($uploadFile);
    }


    public function testCourseFile()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        $firstUploadedFile = new UploadFile();
        $firstUploadedFile->setName('itslearning_logo.png');
        $firstUploadedFile->setContent(file_get_contents(__DIR__ . '/Resources/itslearning_logo.png'));
        $itslearning->uploadFile($firstUploadedFile);
        $secondUploadedFile = new UploadFile();
        $secondUploadedFile->setName('itslearning_logo.png');
        $secondUploadedFile->setContent(file_get_contents(__DIR__ . '/Resources/itslearning_logo.png'));
        $itslearning->uploadFile($secondUploadedFile);

        /* When */
        $myFileFile = new MyFilesFile();
        $myFileFile->setUserSyncKey(getenv('USER_SYNC_KEY'));
        $myFileFile->setVisibility(MyFilesFile::VISIBILITY_PUBLIC);
        $firstFile = new File();
        $firstFile->setFileSyncKey($firstUploadedFile->getSyncKey());
        $secondFile = new File();
        $secondFile->setFileSyncKey($secondUploadedFile->getSyncKey());
        $myFileFile->setFiles([$firstFile, $secondFile]);
        $result = $itslearning->createMyFilesFile($myFileFile);

        /* Then */
        $this->assertNotEmpty($result->getFiles()[0]->getSyncKey());
        $this->assertNotEmpty($result->getFiles()[1]->getSyncKey());
    }


}