<?php
namespace BobFreelancer\Models;

class Period
{
    /**
     * @var DateTimeInterface
     */
    private $start;

    /**
     * @var DateTimeInterface
     */
    private $stop;

    /**
     * Period constructor.
     * @param DateTimeInterface $start
     * @param DateTimeInterface $stop
     * @throws InvalidArgumentException
     */
    public function __construct(DateTimeInterface $start, DateTimeInterface $stop)
    {
        if($start->getOffset() != $stop->getOffset()){
            throw new InvalidArgumentException('Offset from UTC must be the same for start and stop');
        }
        $this->start = $start;
        $this->stop = $stop;
    }


    public function getCoveredSeconds(): int
    {
        return $this->start->getTimestamp() - $this->stop->getTimestamp();
    }

    /**
     * @return DateTimeInterface
     */
    public function getStart(): DateTimeInterface
    {
        return $this->start;
    }

    /**
     * @return DateTimeInterface
     */
    public function getStop(): DateTimeInterface
    {
        return $this->stop;
    }


}