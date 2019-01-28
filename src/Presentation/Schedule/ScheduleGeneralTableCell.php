<?php

namespace Presentation\Schedule;

use App\Repository\StudentsGroupScheduleReadModel;
use Domain\Time;
use Domain\TimeInterval;

class ScheduleGeneralTableCell
{
    const CLASS_DURATION = 45;

    /**
     * @var StudentsGroupScheduleReadModel
     */
    private $scheduleItem;

    /**
     * @var TimeInterval
     */
    private $timeInterval;

    /**
     * ScheduleGeneralTableCell constructor.
     * @param StudentsGroupScheduleReadModel $scheduleItem
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public function __construct(StudentsGroupScheduleReadModel $scheduleItem)
    {
        $this->scheduleItem = $scheduleItem;
        $this->timeInterval = TimeInterval::fromTimeAndDuration(
            new Time($this->scheduleItem->hour, $this->scheduleItem->minutes),
            $this->scheduleItem->duration
        );
    }

    /**
     * @return TimeInterval
     */
    public function timeInterval()
    {
        return $this->timeInterval;
    }

    /**
     * @return mixed
     */
    public function hour()
    {
        return $this->scheduleItem->hour;
    }

    /**
     * @return mixed
     */
    public function duration()
    {
        return $this->scheduleItem->duration;
    }

    /**
     * @return mixed
     */
    public function minutes()
    {
        return $this->scheduleItem->minutes;
    }

    /**
     * @return mixed
     */
    public function groupName()
    {
        return $this->scheduleItem->group->name;
    }

    /**
     * @return mixed
     */
    public function groupId()
    {
        return $this->scheduleItem->group->id;
    }

    /**
     * @return string
     */
    public function timePeriod()
    {
        list($toHour, $toMinutes) = $this->toTime();

        return sprintf(
            '%s:%s - %s:%s',
            $this->scheduleItem->hour,
            str_pad($this->scheduleItem->minutes, 2, '0'),
            $toHour,
            $toMinutes
        );
    }

    /**
     * @return array
     */
    private function toTime()
    {
        $hour = $this->scheduleItem->hour;

        $duration = self::CLASS_DURATION * $this->scheduleItem->duration;

        if($this->scheduleItem->minutes + $duration > 59) {
            $hour = $hour + floor(($this->scheduleItem->minutes + $duration)/60);
            $minutes = ($this->scheduleItem->minutes + $duration)%60;
        } else {
            $minutes = $this->scheduleItem->minutes + $duration;
        }

        return [$hour, str_pad($minutes, 2, '0')];
    }
}
