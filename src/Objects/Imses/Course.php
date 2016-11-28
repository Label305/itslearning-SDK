<?php


namespace Itslearning\Objects\Imses;


class Course
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $syncKey;

    /**
     * @var string
     */
    private $parentSyncKey;

    /**
     * @var string
     */
    private $userSyncKey;

    /**
     * @var string
     */
    private $shortDescription;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
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
     * @return string
     */
    public function getParentSyncKey()
    {
        return $this->parentSyncKey;
    }

    /**
     * @param string $parentSyncKey
     */
    public function setParentSyncKey(string $parentSyncKey)
    {
        $this->parentSyncKey = $parentSyncKey;
    }

    /**
     * @return string
     */
    public function getUserSyncKey()
    {
        return $this->userSyncKey;
    }

    /**
     * @param string $userSyncKey
     */
    public function setUserSyncKey(string $userSyncKey)
    {
        $this->userSyncKey = $userSyncKey;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription(string $shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

}