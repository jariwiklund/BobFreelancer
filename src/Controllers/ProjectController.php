<?php

namespace BobFreelancer\Controllers;


use BobFreelancer\Http\Response;
use BobFreelancer\Models\Project;
use BobFreelancer\Persistence\FinderInterface;
use BobFreelancer\Persistence\NullCriteria;
use BobFreelancer\Persistence\PersistorInterface;
use BobFreelancer\View\ProjectArrayJsonView;
use BobFreelancer\View\ProjectJsonView;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ProjectController
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
    }

    public function getProject(Project $project): ResponseInterface
    {
        $view = new ProjectJsonView($project);

        return new Response(200, json_encode($view), 'text/json');
    }

    public function getProjects(): ResponseInterface
    {
        $projects = $this->finder->find(new NullCriteria());
        $view = new ProjectArrayJsonView($projects);

        return new Response(200, json_encode($view), 'text/json');
    }
}