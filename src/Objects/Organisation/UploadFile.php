<?php


namespace Itslearning\Objects\Organisation;


class UploadFile
{

    /**
     * @var int
     */
    private $siteId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $syncKey;

    /**
     * @return int
     */
    public function getSiteId(): int
    {
        return $this->siteId;
    }

    /**
     * @param int $siteId
     */
    public function setSiteId(int $siteId)
    {
        $this->siteId = $siteId;
    }

    /**
     * @return string
     */
    public function getContent(): string
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
    public function getName(): string
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

}