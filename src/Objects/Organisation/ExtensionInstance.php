<?php


namespace Itslearning\Objects\Organisation;


class ExtensionInstance implements CourseElement
{

    const LOCATION_COURSE = 'Course';
    const LOCATION_LIBRARY = 'Library';

    /**
     * @var string|null
     */
    private $syncKey;

    /**
     * @var int|null
     */
    private $siteId;

    /**
     * @var string|null
     */
    private $vendorId;

    /**
     * @var string
     */
    private $location;

    /**
     * @var int
     */
    private $extensionId;

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
     * @var bool|null
     */
    private $disallowModification;

    /**
     * @var ExtensionInstanceContent
     */
    private $content;

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
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location)
    {
        $this->location = $location;
    }

    /**
     * @return int
     */
    public function getExtensionId(): int
    {
        return $this->extensionId;
    }

    /**
     * @param int $extensionId
     */
    public function setExtensionId(int $extensionId)
    {
        $this->extensionId = $extensionId;
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
     * @return bool|null
     */
    public function getDisallowModification()
    {
        return $this->disallowModification;
    }

    /**
     * @param bool|null $disallowModification
     */
    public function setDisallowModification($disallowModification)
    {
        $this->disallowModification = $disallowModification;
    }
  
    /**
     * @return ExtensionInstanceContent
     */
    public function getContent(): ExtensionInstanceContent
    {
        return $this->content;
    }

    /**
     * @param ExtensionInstanceContent $content
     */
    public function setContent(ExtensionInstanceContent $content)
    {
        $this->content = $content;
    }

}