<?php

namespace BobFreelancer\Persistence;


use BobFreelancer\Models\Period;
use BobFreelancer\Models\PeriodArray;
use DateTime;
use PDO;
use PDOStatement;

class ProjectWorkFinder
{

    public static function findWorkPeriodsForProject(Project $project): PeriodArray
    {
        //Preferably use some kind of orm like Doctrine instead
        $statement = new PDOStatement("
            SELECT `start`, `stop` 
            FROM project_work_period
            WHERE project_id = :project_id
            ORDER BY `start`
        ");

        $statement->bindValue('project_id', $project->getId());

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $periods = new PeriodArray();
        foreach ($rows as $row){
            $periods->add( ProjectWorkFinder::rowToObject($row) );
        }

        return $periods;
    }

    public static function rowToPeriod(array $row): Period
    {
        return new Period(
            DateTime::createFromFormat('Y-m-d H:i:s', $row['start']),
            DateTime::createFromFormat('Y-m-d H:i:s', $row['stop'])
        );
    }
}