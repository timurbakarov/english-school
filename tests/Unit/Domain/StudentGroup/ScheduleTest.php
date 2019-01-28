<?php

namespace Tests\Unit\Domain\StudentGroup;

use Domain\Education\StudentGroup\Schedule;
use Domain\Education\StudentGroup\Schedule\DayOfWeek;
use Domain\Education\StudentGroup\Schedule\GroupClassDuration;
use Domain\Education\StudentGroup\Schedule\ScheduleItem;
use Domain\Education\StudentGroup\Schedule\ScheduleTime;
use PHPUnit\Framework\TestCase;
class ScheduleTest extends TestCase
{
    public function test_dont_add_same_schedule_item_twice()
    {
        $schedule = new Schedule(
            new ScheduleItem(new DayOfWeek(1), new ScheduleTime(16, 30), new GroupClassDuration(1)),
            new ScheduleItem(new DayOfWeek(1), new ScheduleTime(16, 30), new GroupClassDuration(1))
        );

        $this->assertEquals(1, count($schedule->items()));
    }

    public function test_equals()
    {
        $schedule1 = new Schedule(
            new ScheduleItem(new DayOfWeek(1), new ScheduleTime(16, 30), new GroupClassDuration(1)),
            new ScheduleItem(new DayOfWeek(3), new ScheduleTime(12, 00), new GroupClassDuration(2))
        );

        $schedule2 = new Schedule(
            new ScheduleItem(new DayOfWeek(1), new ScheduleTime(16, 30), new GroupClassDuration(1)),
            new ScheduleItem(new DayOfWeek(3), new ScheduleTime(12, 00), new GroupClassDuration(2))
        );

        $schedule3 = new Schedule(
            new ScheduleItem(new DayOfWeek(3), new ScheduleTime(12, 00), new GroupClassDuration(2)),
            new ScheduleItem(new DayOfWeek(1), new ScheduleTime(16, 30), new GroupClassDuration(1))
        );

        $schedule4 = new Schedule(
            new ScheduleItem(new DayOfWeek(1), new ScheduleTime(16, 30), new GroupClassDuration(1)),
            new ScheduleItem(new DayOfWeek(4), new ScheduleTime(12, 00), new GroupClassDuration(2))
        );

        $schedule5 = new Schedule(
            new ScheduleItem(new DayOfWeek(1), new ScheduleTime(16, 30), new GroupClassDuration(1)),
            new ScheduleItem(new DayOfWeek(3), new ScheduleTime(12, 00), new GroupClassDuration(2)),
            new ScheduleItem(new DayOfWeek(3), new ScheduleTime(12, 00), new GroupClassDuration(3))
        );

        $this->assertTrue($schedule1->equals($schedule2));
        $this->assertTrue($schedule1->equals($schedule3));
        $this->assertFalse($schedule1->equals($schedule4));
        $this->assertFalse($schedule1->equals($schedule5));
    }
}
