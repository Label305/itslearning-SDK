<?php


namespace Itslearning\Objects\Organisation;


class CourseElementPage implements CourseElement
{

    /**
     * @var string|null
     */
    private $syncKey;

    /**
     * @var int|null
     */
    private $siteId = null;

    /**
     * @var string|null
     */
    private $vendorId;

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
     * @var PageContent
     */
    private $content;

    /**
     * @return string|null
     */
    public function getSyncKey()
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
     * @return PageContent
     */
    public function getContent(): PageContent
    {
        return $this->content;
    }

    /**
     * @param PageContent $content
     */
    public function setContent(PageContent $content)
    {
        $this->content = $content;
    }

}