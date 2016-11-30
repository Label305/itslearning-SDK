<?php


namespace Itslearning\Objects;


class PaginatedResponse
{

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $total;

    /**
     * @var array
     */
    private $data;

    /**
     * PaginatedResponse constructor.
     * @param int   $page
     * @param int   $total
     * @param array $data
     */
    public function __construct(int $page, int $total, array $data)
    {
        $this->page = $page;
        $this->total = $total;
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

}