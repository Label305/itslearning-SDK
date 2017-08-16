<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Objects\Organisation\Column;
use Itslearning\Objects\Organisation\CoursePlanner;
use Itslearning\Objects\Organisation\CustomColumnData;
use Itslearning\Objects\Organisation\LearningObjective;
use Itslearning\Objects\Organisation\Lesson;
use Itslearning\Objects\Organisation\Topic;
use Itslearning\Requests\Request;

class CreateCoursePlannerRequest implements Request
{

    const MESSAGE_TYPE_NAME = 'Create.Course.Planner';

    /**
     * @var CoursePlanner
     */
    private $coursePlanner;
    /**
     * @var int
     */
    private $messageTypeIdentifier;

    /**
     * CreateCoursePlannerRequest constructor.
     * @param CoursePlanner $coursePlanner
     * @param int           $messageTypeIdentifier
     */
    public function __construct(CoursePlanner $coursePlanner, int $messageTypeIdentifier)
    {
        $this->coursePlanner = $coursePlanner;
        $this->messageTypeIdentifier = $messageTypeIdentifier;
    }

    /**
     * @param ItslearningClient $client
     * @return CoursePlanner
     */
    public function execute(ItslearningClient $client): CoursePlanner
    {
        $arguments = $this->map($this->coursePlanner);

        $result = $client->message($this->messageTypeIdentifier, $arguments);

        return $this->coursePlanner;
    }

    private function map(CoursePlanner $coursePlanner)
    {
        $payload = [];
        $payload = $this->addCourseDetails($coursePlanner, $payload);
        $payload['Planner'] = [
            'Columns' => []
        ];
        if (count($coursePlanner->getTopicColumns()) > 0) {
            $columns = $coursePlanner->getTopicColumns();
            $payload['Planner']['Columns']['TopicColumns'] = $this->mapColumns($columns);
        }
        if (count($coursePlanner->getLessonColumns()) > 0) {
            $columns = $coursePlanner->getLessonColumns();
            $payload['Planner']['Columns']['LessonColumns'] = $this->mapColumns($columns);
        }
        if (count($coursePlanner->getTopics()) > 0) {
            $topics = $coursePlanner->getTopics();
            $payload['Planner']['Topics'] = $this->mapTopics($topics);
        }

        $message = [
            'xmlns:' => 'urn:message-schema'
        ];
        if ($coursePlanner->getSyncKey() !== null) {
            $message['SyncKeys'] = [
                'SyncKey' => $coursePlanner->getSyncKey()
            ];
        }
        $message['CreateCoursePlanner'] = [$payload];

        return [
            'Message' => $message
        ];
    }

    /**
     * @param CoursePlanner $coursePlanner
     * @param               $payload
     * @return mixed
     */
    private function addCourseDetails(CoursePlanner $coursePlanner, $payload)
    {
        if ($coursePlanner->getCourseId()) {
            $payload['CourseId'] = $coursePlanner->getCourseId();
        }
        if ($coursePlanner->getCourseSyncKey()) {
            $payload['CourseSyncKey'] = $coursePlanner->getCourseSyncKey();
        }
        if ($coursePlanner->getUserId()) {
            $payload['UserId'] = $coursePlanner->getUserId();
        }
        if ($coursePlanner->getUserSyncKey()) {
            $payload['UserSyncKey'] = $coursePlanner->getUserSyncKey();

            return $payload;
        }

        return $payload;
    }

    /**
     * @param Column[] $columns
     * @return array
     */
    private function mapColumns(array $columns): array
    {
        $mappedColumns = [
            'Column' => []
        ];
        foreach ($columns as $column) {
            $mappedColumns['Column'][] = [
                'ColumnId' => $column->getColumnId(),
                'Name' => $column->getName(),
                'Type' => $column->getType(),
                'ShowOnCoursePage' => $column->isShowOnCoursePage() ? 'true' : 'false',
                'ShowInGrid' => $column->isShowInGrid() ? 'true' : 'false',
                'VisibleForAll' => $column->isVisibleForAll() ? 'true' : 'false'
            ];
        }

        return $mappedColumns;
    }

    /**
     * @param Topic[] $topics
     * @return array
     */
    private function mapTopics(array $topics): array
    {
        $mappedTopics = [
            'Topic' => []
        ];

        foreach ($topics as $topic) {
            $mappedTopic = [
                'Name' => $topic->getName()
            ];
            if (count($topic->getLessons()) > 0) {
                $mappedTopic['Lessons'] = $this->mapLessons($topic->getLessons());
            }
            if (count($topic->getLearningObjectives()) > 0) {
                $mappedTopic['LearningObjectives'] = $this->mapLearningObjectives($topic->getLearningObjectives());
            }
            if (count($topic->getCustomColumnsData()) > 0) {
                $mappedTopic['CustomColumnsData'] = $this->mapCustomColumnsData($topic->getCustomColumnsData());
            }

            $mappedTopics['Topic'][] = $mappedTopic;
        }

        return $mappedTopics;
    }

    /**
     * @param Lesson[] $lessons
     * @return array
     */
    private function mapLessons(array $lessons): array
    {
        $mappedLessons = [
            'Lesson' => []
        ];

        foreach ($lessons as $lesson) {
            $mappedLesson = [
                'Name' => $lesson->getName()
            ];
            if ($lesson->getLessonOutline() !== null) {
                $mappedLesson['LessonOutline'] = $lesson->getLessonOutline();
            }
            if ($lesson->getStartDateTime() !== null) {
                $mappedLesson['StartDateTime'] = $lesson->getStartDateTime();
            }
            if ($lesson->getStopDateTime() !== null) {
                $mappedLesson['StopDateTime'] = $lesson->getStopDateTime();
            }
            if ($lesson->getClassHours() !== null) {
                $mappedLesson['ClassHours'] = $lesson->getClassHours();
            }
            if(count($lesson->getCustomColumnsData()) > 0) {
                $mappedLesson['CustomColumnsData'] = $this->mapCustomColumnsData($lesson->getCustomColumnsData());
            }

            $mappedLessons['Lesson'][] = $mappedLesson;
        }

        return $mappedLessons;
    }

    /**
     * @param CustomColumnData[] $customColumnsData
     * @return array
     */
    private function mapCustomColumnsData(array $customColumnsData): array
    {
        $mappedCustomColumnsData = [
            'CustomColumnData' => []
        ];
        foreach ($customColumnsData as $customColumnData) {
            $mappedCustomColumnsData['CustomColumnData'][] = [
                'ColumnId' => $customColumnData->getColumnId(),
                'Text' => $customColumnData->getText()
            ];
        }

        return $mappedCustomColumnsData;
    }

    /**
     * @param LearningObjective[] $learningObjectives
     * @return array
     */
    private function mapLearningObjectives(array $learningObjectives): array
    {
        $mappedLearningObjectives = [
            'LearningObjective' => []
        ];
        foreach ($learningObjectives as $learningObjective) {
            $mappedLearningObjectives['LearningObjective'][] = [
                'ColumnId' => $learningObjective->getColumndId(),
                'LearningObjectiveId' => $learningObjective->getLearningObjectiveId()
            ];
        }

        return $mappedLearningObjectives;
    }

}