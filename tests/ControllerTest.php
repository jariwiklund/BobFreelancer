<?php

use BobFreelancer\Controllers\ProjectController;
use BobFreelancer\Controllers\ProjectWorkPeriodController;
use BobFreelancer\Http\Request;
use BobFreelancer\Http\Response;
use BobFreelancer\Http\StringStream;
use BobFreelancer\Http\Uri;
use BobFreelancer\Models\Period;
use BobFreelancer\Models\PeriodArray;
use BobFreelancer\Models\Project;
use BobFreelancer\Models\ProjectArray;
use BobFreelancer\Models\ProjectWorkPeriod;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ControllerTest extends TestCase
{

    public function test_that_we_can_save_a_work_period()
    {
        $test_project = new Project(Uuid::uuid4(), 'test project', new PeriodArray());
        $test_period = new Period(
            new DateTime(),
            (new DateTime())->modify('+2 hours')
        );

        $test_periods = new PeriodArray();
        $test_periods->add($test_period);

        $expected_work_period = new ProjectWorkPeriod($test_project, $test_period);

        $persistor = new TestPersistor(function($actual_work_period) use($expected_work_period){
           $this->assertEquals($expected_work_period, $actual_work_period);
        });

        $controller = new ProjectWorkPeriodController(
            new Request(
                'POST',
                new Uri('/projects/'.rawurlencode($test_project->getId()).'/work-periods'),
                new StringStream( json_encode([
                    'start' => $test_period->getStart()->format(DateTime::RFC3339),
                    'start' => $test_period->getStop()->format(DateTime::RFC3339)
                ]) )
            ),
            $persistor,
            new TestFinder( $test_periods )
        );

        $response = $controller->registerWorkPeriod($test_project, $test_period);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function test_that_we_can_get_work_periods_for_project()
    {
        $test_project = new Project(Uuid::uuid4(), 'test project', new PeriodArray());

        $test_periods = new PeriodArray();
        //Add two times two hours
        $test_periods->add(
            new Period(
                new DateTime(),
                (new DateTime())->modify('+2 hours')
            )
        );
        $test_periods->add(
            new Period(
                (new DateTime())->modify('+4 hours'),
                (new DateTime())->modify('+6 hours')
            )
        );

        $controller = new ProjectWorkPeriodController(
            new Request(
                'GET',
                new Uri('/projects/'.rawurlencode($test_project->getId()).'/work-periods'),
                new StringStream( '' )
            ),
            new TestPersistor(function(){}),
            new TestFinder( $test_periods )
        );

        $response = $controller->getWorkPeriodsForProject($test_project);

        $this->assertInstanceOf(Response::class, $response);
        $json = json_decode($response->getBody()->__toString());

        $totalSeconds = (2*2*3600);//two times two hours
        $this->assertEquals($totalSeconds, $json->total_seconds);
        $this->assertCount(2, $json->periods);
    }

    public function test_that_we_can_get_a_project()
    {
        $test_periods = new PeriodArray();
        //Add two times two hours
        $test_periods->add(
            new Period(
                new DateTime(),
                (new DateTime())->modify('+2 hours')
            )
        );
        $test_periods->add(
            new Period(
                (new DateTime())->modify('+4 hours'),
                (new DateTime())->modify('+6 hours')
            )
        );

        $test_project = new Project(Uuid::uuid4(), 'test project', $test_periods);

        $controller = new ProjectController(
            new Request(
                'GET',
                new Uri('/projects/'.rawurlencode($test_project->getId())),
                new StringStream( '' )
            ),
            new TestPersistor(function(){}),
            new TestFinder( ProjectArray::fromArray([$test_project]) )
        );

        $response = $controller->getProject($test_project);

        $this->assertInstanceOf(Response::class, $response);
        $json = json_decode($response->getBody()->__toString());

        $total_seconds = (2*2*3600);//two times two hours
        $this->assertEquals($test_project->getName(), $json->name);
        $this->assertCount(2, $json->work_periods->periods);
        $this->assertEquals($total_seconds, $json->work_periods->total_seconds);

    }

    public function test_that_we_can_get_projects()
    {
        $test_periods = new PeriodArray();
        //Add two times two hours
        $test_periods->add(
            new Period(
                new DateTime(),
                (new DateTime())->modify('+2 hours')
            )
        );
        $test_periods->add(
            new Period(
                (new DateTime())->modify('+4 hours'),
                (new DateTime())->modify('+6 hours')
            )
        );

        $test_project1 = new Project(Uuid::uuid4(), 'test project1', $test_periods);
        $test_project2 = new Project(Uuid::uuid4(), 'test project2', $test_periods);

        $controller = new ProjectController(
            new Request(
                'GET',
                new Uri('/projects'),
                new StringStream( '' )
            ),
            new TestPersistor(function(){}),
            new TestFinder( ProjectArray::fromArray([$test_project1, $test_project2]) )
        );

        $response = $controller->getProjects();

        $this->assertInstanceOf(Response::class, $response);
        $json = json_decode($response->getBody()->__toString());

        $this->assertCount(2, $json);

        $total_seconds = (2*2*3600);//two times two hours
        $this->assertEquals($test_project1->getName(), $json[0]->name);
        $this->assertEquals($test_project2->getName(), $json[1]->name);
        $this->assertCount(2, $json[0]->work_periods->periods);
        $this->assertEquals($total_seconds, $json[0]->work_periods->total_seconds);
        $this->assertCount(2, $json[1]->work_periods->periods);
        $this->assertEquals($total_seconds, $json[1]->work_periods->total_seconds);

    }
}