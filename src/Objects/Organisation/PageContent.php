<?php


namespace Itslearning\Objects\Organisation;


class PageContent
{

    /**
     * @var ContentBlockSet[]
     */
    private $contentBlockSets = [];

    /**
     * @return ContentBlockSet[]
     */
    public function getContentBlockSets(): array
    {
        return $this->contentBlockSets;
    }

    /**
     * @param ContentBlockSet[] $contentBlockSets
     */
    public function setContentBlockSets(array $contentBlockSets)
    {
        $this->contentBlockSets = $contentBlockSets;
    }

}