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
        $json = [
            'id' => $this->project->getId(),
            'name' => $this->project->getName(),
            'work_periods' => [],
            'total_seconds' => 0
        ];

        /** @var PeriodArray $work_period */
        foreach ($this->project->getWorkPeriods() as $work_period )
        {
            $json['work_periods'][] = new PeriodJsonView($work_period);
            $json['total_seconds'] += $work_period->getCoveredSeconds();
        }

        return $json;
    }
}