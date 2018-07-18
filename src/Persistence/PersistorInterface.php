<?php

namespace BobFreelancer\Persistence;


interface PersistorInterface
{
    public function persist($model);

}