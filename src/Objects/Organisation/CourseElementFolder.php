<?php


namespace Itslearning\Objects\Organisation;


class CourseElementFolder implements CourseElement
{

    const SECURITY_SECURE = 'Secure';
    const SECURITY_INHERIT = 'Inherit';
    const SECURITY_LOCKED = 'Locked';

    /**
     * @var string|null
     */
    private $syncKey;

    /**
     * @var int|null
     */
    private $courseId;

    /**
     * @var int|null
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
     * @var boolean|null
     */
    private $active;

    /**
     * Enum type: Secure, Inheric, Locked
     * @var string
     */
    private $security;

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
     * @return int|null
     */
    public function getCourseSyncKey()
    {
        return $this->courseSyncKey;
    }

    /**
     * @param int|null $courseSyncKey
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
     * @return string
     */
    public function getSecurity(): string
    {
        return $this->security;
    }

    /**
     * @param string $security
     */
    public function setSecurity(string $security)
    {
        $this->security = $security;
    }
   
}
