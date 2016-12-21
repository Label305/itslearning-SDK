<?php


namespace Itslearning\Objects\Organisation;


class CoursePlanner
{

    /**
     * @var string
     */
    private $syncKey;

    /**
     * @var string|null
     */
    private $courseId;

    /**
     * @var string|null
     */
    private $courseSyncKey;

    /**
     * @var string|null
     */
    private $userId;

    /**
     * @var string|null
     */
    private $userSyncKey;

    /**
     * @var Column[]
     */
    private $topicColumns;

    /**
     * @var Column[]
     */
    private $lessonColumns;

    /**
     * @var Topic[]
     */
    private $topics;

    /**
     * @return string
     */
    public function getSyncKey(): string
    {
        return $this->syncKey;
    }

    /**
     * @param string $syncKey
     */
    public function setSyncKey(string $syncKey)
    {
        $this->syncKey = $syncKey;
    }

    /**
     * @return null|string
     */
    public function getCourseId()
    {
        return $this->courseId;
    }

    /**
     * @param null|string $courseId
     */
    public function setCourseId($courseId)
    {
        $this->courseId = $courseId;
    }

    /**
     * @return null|string
     */
    public function getCourseSyncKey()
    {
        return $this->courseSyncKey;
    }

    /**
     * @param null|string $courseSyncKey
     */
    public function setCourseSyncKey($courseSyncKey)
    {
        $this->courseSyncKey = $courseSyncKey;
    }

    /**
     * @return null|string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param null|string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return null|string
     */
    public function getUserSyncKey()
    {
        return $this->userSyncKey;
    }

    /**
     * @param null|string $userSyncKey
     */
    public function setUserSyncKey($userSyncKey)
    {
        $this->userSyncKey = $userSyncKey;
    }

    /**
     * @return Column[]
     */
    public function getTopicColumns(): array
    {
        return $this->topicColumns ?? [];
    }

    /**
     * @param Column[] $topicColumns
     */
    public function setTopicColumns(array $topicColumns)
    {
        $this->topicColumns = $topicColumns;
    }

    /**
     * @return Column[]
     */
    public function getLessonColumns(): array
    {
        return $this->lessonColumns ?? [];
    }

    /**
     * @param Column[] $lessonColumns
     */
    public function setLessonColumns(array $lessonColumns)
    {
        $this->lessonColumns = $lessonColumns;
    }

    /**
     * @return Topic[]
     */
    public function getTopics(): array
    {
        return $this->topics;
    }

    /**
     * @param Topic[] $topics
     */
    public function setTopics(array $topics)
    {
        $this->topics = $topics;
    }

}