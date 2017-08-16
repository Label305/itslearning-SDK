<?php


namespace Itslearning\Objects\Organisation;


class FileContent
{
    /**
     * @var int
     */
    private $fileId;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $contentType;

    /**
     * @return int
     */
    public function getFileId(): int
    {
        return $this->fileId;
    }

    /**
     * @param int $fileId
     */
    public function setFileId(int $fileId)
    {
        $this->fileId = $fileId;
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
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
    }

}