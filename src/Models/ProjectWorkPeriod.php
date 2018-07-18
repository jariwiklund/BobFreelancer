<?php

namespace BobFreelancer\Models;


class ProjectWorkPeriod
{

    /**
     * @var Project
     */
    private $project;

    /**
     * @var Period
     */
    private $work_period;

    /**
     * ProjectWorkPeriod constructor.
     * @param Project $project
     * @param Period $work_period
     */
    public function __construct(Project $project, Period $work_period)
    {
        $this->project = $project;
        $this->work_period = $work_period;
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @return Period
     */
    public function getWorkPeriod(): Period
    {
        return $this->work_period;
    }
}