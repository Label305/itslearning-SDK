<?php


namespace Itslearning\Objects\Organisation;


class Column
{

    const TYPE_CUSTOM = 'Custom';
    const TYPE_TOPIC = 'Topic';
    const TYPE_LESSON = 'Lesson';
    const TYPE_LESSON_OUTLINE = 'LessonOutline';
    const TYPE_DATE = 'Date';
    const TYPE_CLASS_HOURS = 'ClassHours';
    const TYPE_LEARNING_OBJECTIVES = 'LearningObjectives';
    const TYPE_RESOURCES = 'Resources';
    const TYPE_ACTIVITIES = 'Activities';

    /**
     * @var int
     */
    private $columnId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $showOnCoursePage;

    /**
     * @var bool
     */
    private $showInGrid;

    /**
     * @var bool
     */
    private $visibleForAll;

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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return boolean
     */
    public function isShowOnCoursePage(): bool
    {
        return $this->showOnCoursePage ?? true;
    }

    /**
     * @param boolean $showOnCoursePage
     */
    public function setShowOnCoursePage(bool $showOnCoursePage)
    {
        $this->showOnCoursePage = $showOnCoursePage;
    }

    /**
     * @return boolean
     */
    public function isShowInGrid(): bool
    {
        return $this->showInGrid ?? true;
    }

    /**
     * @param boolean $showInGrid
     */
    public function setShowInGrid(bool $showInGrid)
    {
        $this->showInGrid = $showInGrid;
    }

    /**
     * @return boolean
     */
    public function isVisibleForAll(): bool
    {
        return $this->visibleForAll ?? true;
    }

    /**
     * @param boolean $visibleForAll
     */
    public function setVisibleForAll(bool $visibleForAll)
    {
        $this->visibleForAll = $visibleForAll;
    }

}