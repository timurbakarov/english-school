<?php

namespace Infr\Schedule;

class DaysOfWeek
{
    /**
     * @var array
     */
    private $days = [];

    /**
     * DaysOfWeek constructor.
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public function __construct()
    {
        $this->days = [
            new DayOfWeek(1, 'Понедельник'),
            new DayOfWeek(2, 'Вторник'),
            new DayOfWeek(3, 'Среда'),
            new DayOfWeek(4, 'Четверг'),
            new DayOfWeek(5, 'Пятница'),
            new DayOfWeek(6, 'Суббота'),
            new DayOfWeek(7, 'Воскресенье'),
        ];
    }

    /**
     * @param $index
     * @return mixed
     */
    public static function dayShortByIndex($index)
    {
        $daysShort = [
            1 => 'пн',
            2 => 'вт',
            3 => 'ср',
            4 => 'чт',
            5 => 'пт',
            6 => 'сб',
            7 => 'вс',
        ];

        return $daysShort[$index];
    }

    /**
     * @return array
     */
    public function days()
    {
        return $this->days;
    }
}
