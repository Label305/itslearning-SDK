<?php


namespace Itslearning\Objects\Organisation;


class LearningObjective
{

    /**
     * @var int
     */
    private $columndId;

    /**
     * @var string
     */
    private $learningObjectiveId;

    /**
     * @return int
     */
    public function getColumndId(): int
    {
        return $this->columndId;
    }

    /**
     * @param int $columndId
     */
    public function setColumndId(int $columndId)
    {
        $this->columndId = $columndId;
    }

    /**
     * @return string
     */
    public function getLearningObjectiveId(): string
    {
        return $this->learningObjectiveId;
    }

    /**
     * @param string $learningObjectiveId
     */
    public function setLearningObjectiveId(string $learningObjectiveId)
    {
        $this->learningObjectiveId = $learningObjectiveId;
    }

}