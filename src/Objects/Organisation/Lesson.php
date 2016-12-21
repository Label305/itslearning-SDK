<?php


namespace Itslearning\Objects\Organisation;


class Lesson
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $lessonOutline;

    /**
     * @var string|null
     */
    private $startDateTime;

    /**
     * @var string|null
     */
    private $stopDateTime;

    /**
     * @var int|null
     */
    private $classHours;

    /**
     * @var CustomColumnData[]
     */
    private $customColumnsData = [];

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
     * @return null|string
     */
    public function getLessonOutline()
    {
        return $this->lessonOutline;
    }

    /**
     * @param null|string $lessonOutline
     */
    public function setLessonOutline($lessonOutline)
    {
        $this->lessonOutline = $lessonOutline;
    }

    /**
     * @return null|string
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    /**
     * @param null|string $startDateTime
     */
    public function setStartDateTime($startDateTime)
    {
        $this->startDateTime = $startDateTime;
    }

    /**
     * @return null|string
     */
    public function getStopDateTime()
    {
        return $this->stopDateTime;
    }

    /**
     * @param null|string $stopDateTime
     */
    public function setStopDateTime($stopDateTime)
    {
        $this->stopDateTime = $stopDateTime;
    }

    /**
     * @return int|null
     */
    public function getClassHours()
    {
        return $this->classHours;
    }

    /**
     * @param int|null $classHours
     */
    public function setClassHours($classHours)
    {
        $this->classHours = $classHours;
    }
    
    /**
     * @return CustomColumnData[]
     */
    public function getCustomColumnsData(): array
    {
        return $this->customColumnsData;
    }
    
    /**
     * @param CustomColumnData[] $customColumnsData
     */
    public function setCustomColumnsData(array $customColumnsData)
    {
        $this->customColumnsData = $customColumnsData;
    }

}