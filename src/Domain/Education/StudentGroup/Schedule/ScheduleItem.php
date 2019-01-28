<?php

namespace Domain\Education\StudentGroup\Schedule;

class ScheduleItem
{
    /**
     * @var DayOfWeek
     */
    private $dayOfWeek;

    /**
     * @var ScheduleTime
     */
    private $time;

    /**
     * @var GroupClassDuration
     */
    private $duration;

    /**
     * ScheduleItem constructor.
     * @param DayOfWeek $dayOfWeek
     * @param ScheduleTime $time
     * @param GroupClassDuration $duration
     */
    public function __construct(DayOfWeek $dayOfWeek, ScheduleTime $time, GroupClassDuration $duration)
    {
        $this->dayOfWeek = $dayOfWeek;
        $this->time = $time;
        $this->duration = $duration;
    }

    /**
     * @param string $data
     * @return ScheduleItem
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public static function fromString(string $data)
    {
        list($dayOfWeek, $time, $duration) = explode(',', $data);
        list($hour, $minutes) = explode(':', $time);

        return new self(new DayOfWeek($dayOfWeek), new ScheduleTime($hour, $minutes), new GroupClassDuration($duration));
    }

    /**
     * @return DayOfWeek
     */
    public function dayOfWeek()
    {
        return $this->dayOfWeek;
    }

    /**
     * @return ScheduleTime
     */
    public function time()
    {
        return $this->time;
    }

    /**
     * @return GroupClassDuration
     */
    public function duration()
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s,%s,%s', $this->dayOfWeek, $this->time, $this->duration);
    }

    /**
     * @param ScheduleItem $scheduleItem
     * @return bool
     */
    public function equals(ScheduleItem $scheduleItem)
    {
        return $scheduleItem->time()->equals($this->time)
            && $scheduleItem->dayOfWeek()->equals($this->dayOfWeek)
            && $scheduleItem->duration()->equals($this->duration);
    }
}
