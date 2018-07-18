<?php

namespace BobFreelancer\Persistence;


use Traversable;

interface FinderInterface
{
    public function find(CriteriaInterface $criteria): Traversable;

    /**
     * @param CriteriaInterface $criteria
     * @return mixed
     * @throws NothingFoundByCriteriaException
     */
    public function get(CriteriaInterface $criteria);
}