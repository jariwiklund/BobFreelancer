<?php

namespace BobFreelancer\View;


use BobFreelancer\Models\Project;
use BobFreelancer\Models\PeriodArray;
use JsonSerializable;

class ProjectJsonView implements JsonSerializable
{
    /**
     * @var Project
     */
    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->project->getId(),
            'name' => $this->project->getName(),
            'work_periods' => new PeriodArrayJsonView($this->project->getWorkPeriods())
        ];
    }
}