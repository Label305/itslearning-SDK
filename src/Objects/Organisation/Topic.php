<?php


namespace Itslearning\Objects\Organisation;


class Topic
{

    private $name;

    /**
     * @var CustomColumnData[]
     */
    private $customColumnsData;

    /**
     * @var LearningObjective[]
     */
    private $learningObjectives;

    /**
     * @var Lesson[]
     */
    private $lessons;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return CustomColumnData[]
     */
    public function getCustomColumnsData(): array
    {
        return $this->customColumnsData ?? [];
    }

    /**
     * @param CustomColumnData[] $customColumnsData
     */
    public function setCustomColumnsData(array $customColumnsData)
    {
        $this->customColumnsData = $customColumnsData;
    }

    /**
     * @return LearningObjective[]
     */
    public function getLearningObjectives(): array
    {
        return $this->learningObjectives ?? [];
    }

    /**
     * @param LearningObjective[] $learningObjectives
     */
    public function setLearningObjectives(array $learningObjectives)
    {
        $this->learningObjectives = $learningObjectives;
    }

    /**
     * @return Lesson[]
     */
    public function getLessons(): array
    {
        return $this->lessons ?? [];
    }

    /**
     * @param Lesson[] $lessons
     */
    public function setLessons(array $lessons)
    {
        $this->lessons = $lessons;
    }

}