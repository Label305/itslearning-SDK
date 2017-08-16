<?php


namespace Itslearning\Objects\Organisation;


class ContentBlockSet
{

    /**
     * @var ContentBlock
     */
    private $contentBlock;

    /**
     * @var FileContent[]
     */
    private $fileContents = [];

    /**
     * @return ContentBlock
     */
    public function getContentBlock(): ContentBlock
    {
        return $this->contentBlock;
    }

    /**
     * @param ContentBlock $contentBlock
     */
    public function setContentBlock(ContentBlock $contentBlock)
    {
        $this->contentBlock = $contentBlock;
    }

    /**
     * @return FileContent[]
     */
    public function getFileContents(): array
    {
        return $this->fileContents;
    }

    /**
     * @param FileContent[] $fileContents
     */
    public function setFileContents(array $fileContents)
    {
        $this->fileContents = $fileContents;
    }
    
}