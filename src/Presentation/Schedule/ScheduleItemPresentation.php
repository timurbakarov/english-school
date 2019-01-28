<?php

namespace Presentation\Schedule;

class ScheduleItemPresentation
{
    private $daysOfWeek = [
        1 => 'понедельник',
        2 => 'вторник',
        3 => 'среда',
        4 => 'четверг',
        5 => 'пятница',
        6 => 'суббота',
        7 => 'воскресенье',
    ];

    /**
     * @param $item
     * @return mixed
     */
    public function display($item)
    {
        return sprintf('%s, %s', $this->nameOfDayOfWeek($item->day_of_week), $this->time($item->hour, $item->minutes));
    }

    /**
     * @param $items
     * @return string
     */
    public function displayForForm($items)
    {
        return implode(';', array_map(function($item) {
            return sprintf('%s,%s:%s,%s', $item['day_of_week'], $item['hour'], $this->minutesFormat($item['minutes']), $item['duration']);
        }, $items));
    }

    /**
     * @param $dayOfWeek
     * @return mixed
     */
    public function nameOfDayOfWeek($dayOfWeek)
    {
        return $this->daysOfWeek[$dayOfWeek];
    }

    /**
     * @param int $hour
     * @param int $minutes
     * @return string
     */
    private function time(int $hour, int $minutes)
    {
        return $hour . ':' . $this->minutesFormat($minutes);
    }

    /**
     * @param $minutes
     * @return string
     */
    private function minutesFormat($minutes)
    {
        return str_pad($minutes, 2, 0, STR_PAD_LEFT);
    }
}
