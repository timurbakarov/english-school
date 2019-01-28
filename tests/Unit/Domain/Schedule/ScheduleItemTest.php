<?php

namespace Tests\Unit\Domain\Schedule;

use Domain\Education\StudentGroup\Schedule\DayOfWeek;
use Domain\Education\StudentGroup\Schedule\GroupClassDuration;
use Domain\Education\StudentGroup\Schedule\ScheduleItem;
use Domain\Education\StudentGroup\Schedule\ScheduleTime;
use PHPUnit\Framework\TestCase;

class ScheduleItemTest extends TestCase
{
    public function test_equals()
    {
        $scheduleItem = new ScheduleItem(new DayOfWeek(1), new ScheduleTime(10, 0), new GroupClassDuration(1));
        $scheduleItemToCompare = new ScheduleItem(new DayOfWeek(1), new ScheduleTime(10, 0), new GroupClassDuration(1));
        $scheduleItemToCompareNotEqual = new ScheduleItem(new DayOfWeek(2), new ScheduleTime(10, 0), new GroupClassDuration(1));

        $this->assertTrue($scheduleItem->equals($scheduleItemToCompare));
        $this->assertFalse($scheduleItem->equals($scheduleItemToCompareNotEqual));
    }
}
