<?php

use BobFreelancer\Persistence\PersistorInterface;

class TestPersistor implements PersistorInterface
{

    /**
     * @var callable
     */
    private $persist_function;

    public function __construct(callable $persist_function)
    {
        $this->persist_function = $persist_function;
    }

    public function persist($model)
    {
        call_user_func($this->persist_function, $model);
    }
}