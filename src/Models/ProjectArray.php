<?php

namespace BobFreelancer\Models;


class ProjectArray extends AbstractTypedArray
{

    protected function getType(): string
    {
        return Project::class;
    }
}