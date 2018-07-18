<?php

namespace BobFreelancer\Persistence;


use BobFreelancer\Models\Project;

class WorkPeriodsForProjectCriteria implements CriteriaInterface
{
    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }
}