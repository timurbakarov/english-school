<?php

namespace Domain\Education\StudentGroup\Schedule;

use Domain\Exception\InvalidArgumentException;

class ScheduleTime
{
    /**
     * @var int
     */
    private $hour;

    /**
     * @var int
     */
    private $minutes;

    /**
     * ScheduleTime constructor.
     * @param int $hour
     * @param int $minutes
     * @throws InvalidArgumentException
     */
    public function __construct(int $hour, int $minutes)
    {
        if($hour < 0 OR $hour > 23) {
            throw new InvalidArgumentException("Hour is invalid");
        }

        if($minutes < 0 OR $minutes > 59) {
            throw new InvalidArgumentException("Minutes is invalid");
        }

        $this->hour = $hour;
        $this->minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function hour()
    {
        return (string)$this->hour;
    }

    /**
     * @return string
     */
    public function minutes()
    {
        return (string) str_pad($this->minutes, 2, '0', STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->hour}:{$this->minutes}";
    }

    /**
     * @param ScheduleTime $time
     * @return bool
     */
    public function equals(ScheduleTime $time)
    {
        return $time->hour() == $this->hour() && $time->minutes() == $this->minutes();
    }
}
