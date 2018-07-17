<?php
namespace BobFreelancer\Controller;

use BobFreelancer\Http\Response;
use BobFreelancer\Persistence\ProjectFinder;
use BobFreelancer\Persistence\ProjectWorkFinder;
use BobFreelancer\Persistence\ProjectWorkPersistor;
use BobFreelancer\View\ProjectWorkPeriodJsonView;

class ProjectWorkPeriodController
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function registerWorkPeriod(Project $project, Period $period): Response
    {
        //preferably use some persistence framework like doctrine.
        ProjectWorkPersistor::persistWorkPeriod($project, $period);
        return new Response();
    }

    public function getWorkPeriodsForProject(Project $project): Response
    {
        //preferably use some persistence framework like doctrine.
        $workPeriods = ProjectWorkFinder::findWorkPeriodsForProject($project);
        $view = new ProjectWorkPeriodJsonView($workPeriods);

        return new Response(200, json_encode($view), 'text/json');
    }

    public function getWorkPeriods(): Response
    {
        //preferably use some persistence framework like doctrine.
        $projects = ProjectFinder::findProjects();
        $view = new ProjectArrayJsonView($projects);

        return new Response(200, json_encode($view), 'text/json');
    }
}