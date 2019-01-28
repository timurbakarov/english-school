<?php

namespace Domain;

use Domain\Exception\InvalidArgumentException;

class Time
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
        $this->validate($hour, $minutes);

        $this->hour = $hour;
        $this->minutes = $minutes;
    }

    /**
     * @return Time
     * @throws InvalidArgumentException
     */
    public static function now()
    {
        return new self(date('H'), date('i'));
    }

    /**
     * @param string $time
     * @return Time
     * @throws InvalidArgumentException
     */
    public static function fromString(string $time)
    {
        list($hour, $minutes) = explode(':', $time);

        return new self($hour, $minutes);
    }

    /**
     * @param int $minutes
     * @return Time
     * @throws InvalidArgumentException
     */
    public static function fromMinutes(int $minutes)
    {
        if($minutes < 1) {
            throw new InvalidArgumentException("Invalid minutes");
        }

        $hour = floor($minutes/60);
        $minutes = $minutes%60;

        return new self($hour, $minutes);
    }

    /**
     * @return int
     */
    public function hour()
    {
        return $this->hour;
    }

    /**
     * @return int
     */
    public function minutes()
    {
        return $this->minutes;
    }

    /**
     * @param $segment
     * @return string
     */
    public function formatTimeSegment($segment)
    {
        return str_pad($segment, 2, '0', STR_PAD_LEFT);
    }

    /**
     * @return float|int
     */
    public function convertToMinutes()
    {
        return $this->hour * 60 + $this->minutes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->hour}:{$this->formatTimeSegment($this->minutes)}";
    }

    /**
     * @param Time $time
     * @return bool
     */
    public function equals(self $time)
    {
        return $time->hour() == $this->hour() && $time->minutes() == $this->minutes();
    }

    /**
     * @param int $hour
     * @param int $minutes
     * @throws InvalidArgumentException
     */
    private function validate(int $hour, int $minutes)
    {
        if($hour < 0 OR $hour > 23) {
            throw new InvalidArgumentException("Hour is invalid");
        }

        if($minutes < 0 OR $minutes > 59) {
            throw new InvalidArgumentException("Minutes is invalid");
        }
    }
}
