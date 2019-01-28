<?php

namespace Presentation\Schedule;

use Infr\Schedule\DaysOfWeek;
use Illuminate\Support\Collection;

/**
 * Таблица с общим расписанием
 *
 * Class ScheduleGeneralTable
 * @package Presentation\Schedule
 */
class ScheduleCurrentTable
{
    /**
     * @var array
     */
    private $dataByDayNumber = [];

    /**
     * @var
     */
    private $maxDataInDay;

    /**
     * ScheduleGeneralTable constructor.
     * @param Collection $scheduleItems
     */
    public function __construct(Collection $scheduleItems)
    {
        $this->mapDataByDateNumber($scheduleItems);

        $this->maxDataInDay = $this->calculateMaxDataInDay();
    }

    /**
     * @param int $dayNumber
     * @param int $index
     * @return array
     */
    public function dataByDayNumberAndIndex(int $dayNumber, int $index)
    {
        return $this->dataByDayNumber[$dayNumber][$index] ?? [];
    }

    /**
     * @return int
     */
    public function maxDataInDay()
    {
        return $this->maxDataInDay;
    }

    /**
     * @return DaysOfWeek
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public function daysOfWeek()
    {
        return new DaysOfWeek();
    }

    /**
     * @param $scheduleItems
     */
    private function mapDataByDateNumber($scheduleItems)
    {
        foreach($scheduleItems as $scheduleItem) {
            $this->dataByDayNumber[$scheduleItem->day_of_week][] = new ScheduleCurrentTableCell($scheduleItem);
        }
    }

    /**
     * @return int
     */
    private function calculateMaxDataInDay()
    {
        $maxData = 0;

        foreach($this->dataByDayNumber as $dayNumber => $dataByDayNumber) {
            if(count($dataByDayNumber) > $maxData) {
                $maxData = count($dataByDayNumber);
            }
        }

        return $maxData;
    }
}
