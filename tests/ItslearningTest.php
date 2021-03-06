<?php


namespace Tests;


use Itslearning\Objects\Organisation\CalendarEvent;

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

    public function testCreateExtension()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        $extensionInstance = new ExtensionInstance();
        $extensionInstance->setSyncKey('SDKTEST' . time());
        $extensionInstance->setLocation('Library');
        $extensionInstance->setExtensionId(5000);//Should be 5010
        $extensionInstance->setCourseSyncKey($this->getCourseSyncKey());
        $extensionInstance->setUserSyncKey($this->getUserSyncKey());
        $extensionInstance->setTitle('Sdk - TEST');
        $extensionInstance->setContent('http://www.label305.com');

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
}