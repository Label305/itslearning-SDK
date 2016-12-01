<?php


namespace Itslearning\Objects\Imses;


class Course
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

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
     * @var string
     */
    private $longDescription;

    /**
     * @var string
     */
    private $fullDescription;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $credits;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id ?? '';
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }
    
    /**
     * @return string
     */
    public function getTitle():string
    {
        return $this->title ?? '';
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
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
    public function getShortDescription():string
    {
        return $this->shortDescription ?? '';
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription(string $shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return string
     */
    public function getLongDescription(): string
    {
        return $this->longDescription ?? '';
    }

    /**
     * @param string $longDescription
     */
    public function setLongDescription(string $longDescription)
    {
        $this->longDescription = $longDescription;
    }

    /**
     * @return string
     */
    public function getFullDescription(): string
    {
        return $this->fullDescription ?? '';
    }

    /**
     * @param string $fullDescription
     */
    public function setFullDescription(string $fullDescription)
    {
        $this->fullDescription = $fullDescription;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code ?? '';
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCredits(): string
    {
        return $this->credits ?? '';
    }

    /**
     * @param string $credits
     */
    public function setCredits(string $credits)
    {
        $this->credits = $credits;
    }

}