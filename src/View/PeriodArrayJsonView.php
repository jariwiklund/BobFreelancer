<?php

namespace BobFreelancer\View;


use BobFreelancer\Models\Period;
use BobFreelancer\Models\PeriodArray;
use JsonSerializable;

class PeriodArrayJsonView implements JsonSerializable
{
    /**
     * @var PeriodArray
     */
    private $periods;

    public function __construct(PeriodArray $periods)
    {
        $this->periods = $periods;
    }

    public function jsonSerialize()
    {
        $json = [
            'periods' => [],
            'total_seconds' => 0
        ];

        /** @var Period $period */
        foreach ($this->periods as $period )
        {
            $json['periods'][] = new PeriodJsonView($period);
            $json['total_seconds'] += $period->getCoveredSeconds();
        }

        return $json;
    }
}