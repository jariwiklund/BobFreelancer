<?php

namespace BobFreelancer\View;


use BobFreelancer\Models\Project;
use BobFreelancer\Models\ProjectArray;
use JsonSerializable;

class ProjectArrayJsonView implements JsonSerializable
{
    /**
     * @var ProjectArray
     */
    private $projects;

    public function __construct(ProjectArray $projects)
    {
        $this->projects = $projects;
    }

    public function jsonSerialize()
    {
        $json = [];
        /** @var Project $project */
        foreach ($this->projects as $project){
            $json[] = new ProjectJsonView($project);
        }
        return $json;
    }
}