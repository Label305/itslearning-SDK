<?php


namespace Itslearning\Objects\Organisation;


class CalendarEvent
{

    /** @var string */
    private $syncKey;

    /** @var int|null */
    private $siteId;

    /** @var string|null */
    private $vendorId;

    /** @var \DateTime */
    private $startDateTime;

    /** @var \DateTime */
    private $endDateTime;

    /** @var string|null */
    private $description;

    /** @var string|null */
    private $syncKeyRef;

    /** @var bool|null */
    private $isLesson;

    /** @var int|null */
    private $userId;

    /** @var string|null */
    private $userSyncKey;

    /** @var int|null */
    private $courseId;

    /** @var string|null */
    private $courseSyncKey;

    /** @var int|null */
    private $groupHierarchyId;

    /** @var string|null */
    private $groupHierarchySyncKey;

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
     * @return int|null
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * @param int|null $siteId
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
    }

    /**
     * @return null|string
     */
    public function getVendorId()
    {
        return $this->vendorId;
    }

    /**
     * @param null|string $vendorId
     */
    public function setVendorId($vendorId)
    {
        $this->vendorId = $vendorId;
    }

    /**
     * @return \DateTime
     */
    public function getStartDateTime(): \DateTime
    {
        return $this->startDateTime;
    }

    /**
     * @param \DateTime $startDateTime
     */
    public function setStartDateTime(\DateTime $startDateTime)
    {
        $this->startDateTime = $startDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getEndDateTime(): \DateTime
    {
        return $this->endDateTime;
    }

    /**
     * @param \DateTime $endDateTime
     */
    public function setEndDateTime(\DateTime $endDateTime)
    {
        $this->endDateTime = $endDateTime;
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
    public function getSyncKeyRef()
    {
        return $this->syncKeyRef;
    }

    /**
     * @param null|string $syncKeyRef
     */
    public function setSyncKeyRef($syncKeyRef)
    {
        $this->syncKeyRef = $syncKeyRef;
    }

    /**
     * @return bool|null
     */
    public function isLesson()
    {
        return $this->isLesson;
    }

    /**
     * @param bool $isLesson
     */
    public function setIsLesson($isLesson)
    {
        $this->isLesson = $isLesson;
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
     * @return int|null
     */
    public function getGroupHierarchyId()
    {
        return $this->groupHierarchyId;
    }

    /**
     * @param int|null $groupHierarchyId
     */
    public function setGroupHierarchyId($groupHierarchyId)
    {
        $this->groupHierarchyId = $groupHierarchyId;
    }

    /**
     * @return null|string
     */
    public function getGroupHierarchySyncKey()
    {
        return $this->groupHierarchySyncKey;
    }

    /**
     * @param null|string $groupHierarchySyncKey
     */
    public function setGroupHierarchySyncKey($groupHierarchySyncKey)
    {
        $this->groupHierarchySyncKey = $groupHierarchySyncKey;
    }

}