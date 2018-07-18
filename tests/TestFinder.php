<?php

use BobFreelancer\Persistence\CriteriaInterface;
use BobFreelancer\Persistence\FinderInterface;

class TestFinder implements FinderInterface
{

    /**
     * @var Traversable
     */
    private $result;

    public function __construct(Traversable $result)
    {
        $this->result = $result;
    }

    public function find(CriteriaInterface $criteria): Traversable
    {
        return $this->result;
    }

    /**
     * @param CriteriaInterface $criteria
     * @return mixed
     * @throws \BobFreelancer\Persistence\NothingFoundByCriteriaException
     */
    public function get(CriteriaInterface $criteria)
    {
        foreach ($this->result as $result){
            return $result;
        }
    }
}