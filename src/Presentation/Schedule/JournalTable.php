<?php

namespace Presentation\Schedule;

use Carbon\Carbon;
use Infr\Schedule\DaysOfWeek;

class JournalTable
{
    /**
     * @var Carbon
     */
    private $startDate;

    /**
     * @var Carbon
     */
    private $endDate;

    /**
     * @var
     */
    private $groupId;

    /**
     * @var array
     */
    private $schedule;

    /**
     * @var array
     */
    private $days = [];

    /**
     * JournalTable constructor.
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param $groupId
     */
    public function __construct(Carbon $startDate, Carbon $endDate, $groupId, array $schedule)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->groupId = $groupId;
        $this->schedule = $schedule;
        $this->days = $this->generateDays();
    }

    /**
     * @return bool
     */
    public function isCurrentMonth()
    {
        return $this->startDate->month == (new Carbon())->month;
    }

    /**
     * @return array
     */
    public function days()
    {
        return $this->days;
    }

    /**
     * @return int
     */
    public function daysCount()
    {
        return count($this->days);
    }

    public function classesCount()
    {

    }

    /**
     * @return Carbon
     */
    public function startDate()
    {
        return $this->startDate;
    }

    /**
     * @return Carbon
     */
    public function endDate()
    {
        return $this->endDate;
    }

    /**
     * @return mixed
     */
    public function groupId()
    {
        return $this->groupId;
    }

    /**
     * @return int
     */
    public function year()
    {
        return $this->startDate->format('Y');
    }

    /**
     * @return int
     */
    public function nextUrl()
    {
        $nextMonth = clone $this->endDate;
        $nextMonth->modify("+1 day");

        return 'journal/' . $this->groupId . '/' . $nextMonth->format('Y/n');
    }

    /**
     * @return int
     */
    public function prevUrl()
    {
        $prevMonth = clone $this->startDate;
        $prevMonth->modify("-1 day");

        return 'journal/' . $this->groupId . '/' . $prevMonth->format('Y/n');
    }

    /**
     * @return string
     */
    public function currentWeekUrl()
    {
        return 'journal/' . $this->groupId . '/' . date('Y') . '/' . date('n');
    }

    /**
     * @return string
     */
    public function weekName()
    {
        return monthLabel($this->startDate->format('n'));
    }

    /**
     * @return array
     */
    public function generateDays()
    {
        $days = [];

        $today = new Carbon(date('Y-m-d 00:00:00'));

        $scheduleDaysOfWeek = array_keys($this->schedule);

        for($i=0; $i<$this->endDate->format('t'); $i++) {

            $day = clone $this->startDate;
            $day->modify("+{$i} day");
            $dayOfWeek = (int)$day->format('N');

            if(!in_array($dayOfWeek, $scheduleDaysOfWeek)) {
                continue;
            }

            foreach($this->schedule[$dayOfWeek] as $item) {
                $days[] = [
                    'date' => $day->format('Y-m-d'),
                    'label' => $day->format('j'),
                    'number' => $day->format('j'),
                    'day_of_week' => DaysOfWeek::dayShortByIndex($dayOfWeek),
                    'day_of_week_number' => $dayOfWeek,
                    'is_today' => $today->format('Y-m-d') == $day->format('Y-m-d'),
                    'is_future' => $day > $today && $today->format('Y-m-d') != $day->format('Y-m-d'),
                    'is_past' => $day < $today,
                    'hour' => (int)$item['hour'],
                    'minutes' => (int)$item['minutes'],
                    'duration' => $item['duration'],
                ];
            }
        }

        return $days;
    }
}
