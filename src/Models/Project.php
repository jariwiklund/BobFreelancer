<?php
namespace BobFreelancer\Models;

use BobFreelancer\View\PeriodJsonView;

class Project
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var PeriodArray
     */
    private $work_periods;

    /**
     * @param int $id
     * @param string $name
     */
    public function __construct( int $id, string $name, PeriodArray $work_periods )
    {
        $this->id = $id;
        $this->name = $name;
        $this->work_periods = $work_periods;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function addWorkPeriod(Period $period)
    {
        $this->work_periods->add($period);
    }

    public function getWorkPeriods(): PeriodArray
    {
        return $this->work_periods;
    }
}