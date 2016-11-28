<?php


namespace Itslearning\Objects\Organisation;


class Extension
{

    /**
     * @var string
     */
    private $syncKey;

    /**
     * Either "Course" or "Library"
     * @var string
     */
    private $location;

    /**
     * @var int
     */
    private $extensionId;

    /**
     * @var string
     */
    private $courseSyncKey;

    /**
     * @var string
     */
    private $userSyncKey;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string[]
     */
    private $keywords;

    /**
     * @todo whut is this
     * @var mixed
     */
    private $learningObjectives;

    /**
     * @var string
     */
    private $intendedEndUserRole;

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
    public function getLocation()
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
    public function getExtensionId()
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
     * @return string
     */
    public function getCourseSyncKey()
    {
        return $this->courseSyncKey;
    }

    /**
     * @param string $courseSyncKey
     */
    public function setCourseSyncKey(string $courseSyncKey)
    {
        $this->courseSyncKey = $courseSyncKey;
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
    public function getTitle()
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;
    }

    /**
     * @return mixed
     */
    public function getLearningObjectives()
    {
        return $this->learningObjectives;
    }

    /**
     * @param mixed $learningObjectives
     */
    public function setLearningObjectives($learningObjectives)
    {
        $this->learningObjectives = $learningObjectives;
    }

    /**
     * @return \string[]
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param \string[] $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return string
     */
    public function getIntendedEndUserRole()
    {
        return $this->intendedEndUserRole;
    }

    /**
     * @param string $intendedEndUserRole
     */
    public function setIntendedEndUserRole(string $intendedEndUserRole)
    {
        $this->intendedEndUserRole = $intendedEndUserRole;
    }
}