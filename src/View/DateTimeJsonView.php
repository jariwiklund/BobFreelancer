<?php

namespace BobFreelancer\View;


use DateTime;
use DateTimeInterface;
use JsonSerializable;

class DateTimeJsonView implements JsonSerializable
{

    /**
     * @var DateTimeInterface
     */
    private $date_time;

    public function __construct(DateTimeInterface $date_time)
    {
        $this->date_time = $date_time;
    }

    public function jsonSerialize()
    {
        return $this->date_time->format(DateTime::RFC3339);
    }
}