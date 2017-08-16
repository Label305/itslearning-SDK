<?php


namespace Itslearning\Objects\Organisation;


class CourseElementAssignment implements CourseElement
{

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
     * @var boolean|null
     */
    private $mandatory;

    /**
     * @var int|null
     */
    private $assessment;

    /**
     * @var int|null
     */
    private $maxScore;

    /**
     * @var string|null
     */
    private $useGroups;

    /**
     * @var boolean|null
     */
    private $plagiarism;

    /**
     * @var boolean|null
     */
    private $useAnonymousSubmission;

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
     * @return int|null
     */
    public function getMaxScore()
    {
        return $this->maxScore;
    }

    /**
     * @param int|null $maxScore
     */
    public function setMaxScore($maxScore)
    {
        $this->maxScore = $maxScore;
    }

    /**
     * @return null|string
     */
    public function getUseGroups()
    {
        return $this->useGroups;
    }

    /**
     * @param null|string $useGroups
     */
    public function setUseGroups($useGroups)
    {
        $this->useGroups = $useGroups;
    }

    /**
     * @return bool|null
     */
    public function getPlagiarism()
    {
        return $this->plagiarism;
    }

    /**
     * @param bool|null $plagiarism
     */
    public function setPlagiarism($plagiarism)
    {
        $this->plagiarism = $plagiarism;
    }

    /**
     * @return bool|null
     */
    public function getUseAnonymousSubmission()
    {
        return $this->useAnonymousSubmission;
    }

    /**
     * @param bool|null $useAnonymousSubmission
     */
    public function setUseAnonymousSubmission($useAnonymousSubmission)
    {
        $this->useAnonymousSubmission = $useAnonymousSubmission;
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