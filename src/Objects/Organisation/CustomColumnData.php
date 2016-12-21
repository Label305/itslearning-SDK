<?php


namespace Itslearning\Objects\Organisation;


class CustomColumnData
{

    /**
     * @var int
     */
    private $columnId;

    /**
     * @var string
     */
    private $text;

    /**
     * @return int
     */
    public function getColumnId(): int
    {
        return $this->columnId;
    }

    /**
     * @param int $columnId
     */
    public function setColumnId(int $columnId)
    {
        $this->columnId = $columnId;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

}