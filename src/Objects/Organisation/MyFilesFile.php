<?php


namespace Itslearning\Objects\Organisation;


class MyFilesFile
{

    const VISIBILITY_PUBLIC = 'Public';
    const VISIBILITY_PRIVATE = 'Private';

    /**
     * @var int|null
     */
    private $siteId;

    /**
     * @var string
     */
    private $vendorId;

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
    private $visibility;

    /**
     * @var File[]
     */
    private $files;

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
     * @return string
     */
    public function getVendorId(): string
    {
        return $this->vendorId;
    }

    /**
     * @param string $vendorId
     */
    public function setVendorId(string $vendorId)
    {
        $this->vendorId = $vendorId;
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
    public function getVisibility(): string
    {
        return $this->visibility;
    }

    /**
     * @param string $visibility
     */
    public function setVisibility(string $visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @return File[]
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @param File[] $files
     */
    public function setFiles(array $files)
    {
        $this->files = $files;
    }

}