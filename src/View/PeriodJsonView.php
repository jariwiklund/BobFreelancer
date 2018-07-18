<?php

namespace BobFreelancer\View;


use BobFreelancer\Models\Period;
use JsonSerializable;

class PeriodJsonView implements JsonSerializable
{

    /**
     * @var Period
     */
    private $period;

    /**
     * PeriodJsonView constructor.
     * @param Period $period
     */
    public function __construct(Period $period)
    {
        $this->period = $period;
    }

    public function jsonSerialize()
    {
        return [
            'start' => new DateTimeJsonView($this->period->getStart()),
            'stop' => new DateTimeJsonView($this->period->getStop())
        ];
    }

}