<?php

namespace BobFreelancer\Persistence;


use BobFreelancer\Models\PeriodArray;
use BobFreelancer\Models\Project;
use BobFreelancer\Models\ProjectArray;

class ProjectFinder
{

    public static function rowToObject(array $row): Project
    {
        return new Project( $row['id'], $row['name'], new PeriodArray() );
    }

    public static function findProjects(): ProjectArray
    {
        //Preferably use some kind of orm like Doctrine instead
        $statement = new PDOStatement("
            SELECT id, name, `start`, `stop` 
            FROM project, project_work_period
            WHERE project.id = project_work_period.project_id
            ORDER BY project.id, project_work_period.`start`
        ");

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $projects = new ProjectArray();
        $current_project = null;
        foreach ($rows as $row){
            $project = ProjectFinder::rowToObject($row);
            if($current_project === null || !$current_project->equals($project)){
                $projects->add($current_project);
                $current_project = $project;
            }
            $current_project->addWorkPeriod( ProjectWorkFinder::rowToPeriod($row) );
        }

        return $projects;
    }
}