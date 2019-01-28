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
class ScheduleGeneralTable
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
     * @param $item
     * @return float|int
     */
    public function blockPosition($item)
    {
        return (($item->hour() - 10) * 50) + (int)($item->minutes() > 0 ? 50/(60/$item->minutes()) : 0);
    }

    /**
     * @param $item
     * @return int
     */
    public function blockHeight($item)
    {
        return $item->duration() == 1 ? 50 - (50/4) : 75;
    }

    /**
     * @return array
     */
    public function availableTimeInterval()
    {
        return range(10, 20);
    }

    /**
     * @param int $dayOfWeek
     * @return array|mixed
     */
    public function dataByDayOfWeek(int $dayOfWeek)
    {
        return $this->dataByDayNumber[$dayOfWeek] ?? [];
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
            $this->dataByDayNumber[$scheduleItem->day_of_week][] = new ScheduleGeneralTableCell($scheduleItem);
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
