<?php

namespace Presentation\Schedule;

use App\Repository\StudentsGroupScheduleReadModel;

class ScheduleCurrentTableCell
{
    const CLASS_DURATION = 45;

    /**
     * @var StudentsGroupScheduleReadModel
     */
    private $scheduleItem;

    /**
     * ScheduleGeneralTableCell constructor.
     * @param StudentsGroupScheduleReadModel $scheduleItem
     */
    public function __construct(StudentsGroupScheduleReadModel $scheduleItem)
    {
        $this->scheduleItem = $scheduleItem;
    }

    /**
     * @return mixed
     */
    public function groupId()
    {
        return $this->scheduleItem->group->id;
    }

    /**
     * @return mixed
     */
    public function groupName()
    {
        return $this->scheduleItem->group->name;
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
