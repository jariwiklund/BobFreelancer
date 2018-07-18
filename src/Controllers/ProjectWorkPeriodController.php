<?php
namespace BobFreelancer\Controllers;

use BobFreelancer\Http\Response;
use BobFreelancer\Models\Period;
use BobFreelancer\Models\Project;
use BobFreelancer\Models\ProjectWorkPeriod;
use BobFreelancer\Persistence\FinderInterface;
use BobFreelancer\Persistence\PersistorInterface;
use BobFreelancer\Persistence\WorkPeriodsForProjectCriteria;
use BobFreelancer\View\PeriodArrayJsonView;
use BobFreelancer\View\ProjectWorkPeriodJsonView;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ProjectWorkPeriodController
{

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * preferably use some persistence framework like doctrine.
     * @var PersistorInterface
     */
    private $persistor;

    /**
     * preferably use some persistence framework like doctrine.
     * @var FinderInderface
     */
    private $finder;

    public function __construct(RequestInterface $request, PersistorInterface $persistor, FinderInterface $finder)
    {
        $this->request = $request;
        $this->persistor = $persistor;
        $this->finder = $finder;
        //todo: route request to appropriate method
    }

    public function registerWorkPeriod(Project $project, Period $period): ResponseInterface
    {
        $project_work_period = new ProjectWorkPeriod($project, $period);
        $this->persistor->persist($project_work_period);
        return new Response();
    }

    public function getWorkPeriodsForProject(Project $project): ResponseInterface
    {
        $workPeriods = $this->finder->find(new WorkPeriodsForProjectCriteria($project));
        $view = new PeriodArrayJsonView($workPeriods);

        return new Response(200, json_encode($view), 'text/json');
    }
}