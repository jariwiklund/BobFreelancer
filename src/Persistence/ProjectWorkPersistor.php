<?php
namespace BobFreelancer\Persistence;

use BobFreelancer\Models\Project;

class ProjectWorkPersistor
{

    public static function persistWorkPeriod(Project $project, Period $period)
    {
        //Preferably use some kind of orm like Doctrine
        $statement = new PDOStatement("
            INSERT INTO project_work_period(
                `project_id`,
                `start`,
                `stop`
            ) VALUES (
                :project_id,
                :start,
                :stop
            )
        ");

        $statement->bindValue('project_id', $project->getProject()->getId());
        $statement->bindValue('start', $period->getWorkPeriod()->getStart()->format('Y-m-d H:i:s'));
        $statement->bindValue('stop', $period->getWorkPeriod()->getStop()->format('Y-m-d H:i:s'));
        $statement->execute();
    }
}