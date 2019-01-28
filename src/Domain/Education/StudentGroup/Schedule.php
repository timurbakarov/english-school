<?php

namespace Domain\Education\StudentGroup;

use Domain\Education\StudentGroup\Schedule\ScheduleItem;

class Schedule
{
    /**
     * @var ScheduleItem[]
     */
    private $items = [];

    /**
     * Schedule constructor.
     * @param ScheduleItem[] ...$items
     */
    public function __construct(ScheduleItem ...$items)
    {
        foreach($items as $item) {
            $this->addScheduleItem($item);
        }
    }

    /**
     * @return ScheduleItem[]
     */
    public function items()
    {
        return $this->items;
    }

    /**
     * @param string $schedule
     * @return Schedule
     */
    public static function fromString(string $schedule)
    {
        $items = explode(';', $schedule);

        $items = array_map(function($data) {
            return ScheduleItem::fromString($data);
        }, $items);

        return new self(...$items);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(';', array_map(function(ScheduleItem $item) {
            return (string)$item;
        }, $this->items));
    }

    /**
     * @param Schedule $schedule
     * @return bool
     */
    public function equals(Schedule $schedule)
    {
        if(count($schedule->items()) != count($this->items())) {
            return false;
        }

        foreach($schedule->items() as $scheduleItem) {
            $hasSameScheduleItem = false;

            foreach($this->items() as $item) {
                if($scheduleItem->equals($item)) {
                    $hasSameScheduleItem = true;
                    break;
                }
            }

            if(!$hasSameScheduleItem) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param ScheduleItem $scheduleItem
     * @return $this
     */
    private function addScheduleItem(ScheduleItem $scheduleItem)
    {
        if($this->hasEqualScheduleItem($scheduleItem)) {
            return $this;
        }

        $this->items[] = $scheduleItem;

        return $this;
    }

    /**
     * @param ScheduleItem $scheduleItem
     * @return bool
     */
    private function hasEqualScheduleItem(ScheduleItem $scheduleItem)
    {
        foreach($this->items as $item) {
            if($scheduleItem->equals($item)) {
                return true;
            }
        }

        return false;
    }
}
