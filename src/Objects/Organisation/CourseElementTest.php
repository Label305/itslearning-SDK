<?php


namespace Itslearning\Objects\Organisation;


class CourseElementTest implements CourseElement
{

    const SHOW_RESULT_TEACHER_DECIDES = 'TeacherDecides';
    const SHOW_RESULT_AFTER_EACH = 'AfterEach';
    const SHOW_RESULT_AFTER_ALL = 'AfterAll';
    const SHOW_RESULT_NEVER = 'Never';

    const SHOW_ON_QUESTIONS = 'OnQuestions';
    const SHOW_ON_ALTERNATIVES = 'OnAlternatives';
    const SHOW_NOFEEDBACK = 'Nofeedback';

    /**
     * @var string|null
     */
    private $syncKey;

    /**
     * @var int|null
     */
    private $courseId;

    /**
     * @var string|null
     */
    private $courseSyncKey;

    /**
     * @var string|null
     */
    private $parentSyncKey;

    /**
     * @var bool|null
     */
    private $active;

    /**
     * @var int|null
     */
    private $userId;

    /**
     * @var string|null
     */
    private $userSyncKey;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $deadline;

    /**
     * @var int|null
     */
    private $assessment;

    /**
     * @var bool|null
     */
    private $useScore;

    /**
     * @var bool|null
     */
    private $mandatory;

    /**
     * @var bool|null
     */
    private $scoringMethod;

    /**
     * @var int|null
     */
    private $completionCriteria;

    /**
     * @var bool|null
     */
    private $order;

    /**
     * @var int|null
     */
    private $maxTime;

    /**
     * @var string|null
     */
    private $showResults;

    /**
     * @var string|null
     */
    private $showFeedback;

    /**
     * @var string[]
     */
    private $files = [];

    /**
     * @return null|string
     */
    public function getSyncKey()
    {
        return $this->syncKey;
    }

    /**
     * @param null|string $syncKey
     */
    public function setSyncKey($syncKey)
    {
        $this->syncKey = $syncKey;
    }

    /**
     * @return int|null
     */
    public function getCourseId()
    {
        return $this->courseId;
    }

    /**
     * @param int|null $courseId
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
    public function getParentSyncKey()
    {
        return $this->parentSyncKey;
    }

    /**
     * @param null|string $parentSyncKey
     */
    public function setParentSyncKey($parentSyncKey)
    {
        $this->parentSyncKey = $parentSyncKey;
    }

    /**
     * @return bool|null
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param bool|null $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return int|null
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int|null $userId
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return null|string
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param null|string $deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    /**
     * @return int|null
     */
    public function getAssessment()
    {
        return $this->assessment;
    }

    /**
     * @param int|null $assessment
     */
    public function setAssessment($assessment)
    {
        $this->assessment = $assessment;
    }

    /**
     * @return bool|null
     */
    public function getUseScore()
    {
        return $this->useScore;
    }

    /**
     * @param bool|null $useScore
     */
    public function setUseScore($useScore)
    {
        $this->useScore = $useScore;
    }

    /**
     * @return bool|null
     */
    public function getMandatory()
    {
        return $this->mandatory;
    }

    /**
     * @param bool|null $mandatory
     */
    public function setMandatory($mandatory)
    {
        $this->mandatory = $mandatory;
    }

    /**
     * @return bool|null
     */
    public function getScoringMethod()
    {
        return $this->scoringMethod;
    }

    /**
     * @param bool|null $scoringMethod
     */
    public function setScoringMethod($scoringMethod)
    {
        $this->scoringMethod = $scoringMethod;
    }

    /**
     * @return int|null
     */
    public function getCompletionCriteria()
    {
        return $this->completionCriteria;
    }

    /**
     * @param int|null $completionCriteria
     */
    public function setCompletionCriteria($completionCriteria)
    {
        $this->completionCriteria = $completionCriteria;
    }

    /**
     * @return bool|null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param bool|null $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return int|null
     */
    public function getMaxTime()
    {
        return $this->maxTime;
    }

    /**
     * @param int|null $maxTime
     */
    public function setMaxTime($maxTime)
    {
        $this->maxTime = $maxTime;
    }

    /**
     * @return null|string
     */
    public function getShowResults()
    {
        return $this->showResults;
    }

    /**
     * @param null|string $showResults
     */
    public function setShowResults($showResults)
    {
        $this->showResults = $showResults;
    }

    /**
     * @return null|string
     */
    public function getShowFeedback()
    {
        return $this->showFeedback;
    }

    /**
     * @param null|string $showFeedback
     */
    public function setShowFeedback($showFeedback)
    {
        $this->showFeedback = $showFeedback;
    }

    /**
     * @return string[]
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @param string[] $files
     */
    public function setFiles(array $files)
    {
        $this->files = $files;
    }

}