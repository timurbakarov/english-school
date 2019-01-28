<?php

namespace Tests\Unit\Domain\Schedule;

use Domain\Education\StudentGroup\Schedule\ScheduleTime;
use PHPUnit\Framework\TestCase;

class ScheduleTimeTest extends TestCase
{
    public function test_equals()
    {
        $time1 = new ScheduleTime(10, 0);
        $time2 = new ScheduleTime(10, 0);
        $time3 = new ScheduleTime(15, 45);

        $this->assertTrue($time1->equals($time2));
        $this->assertFalse($time1->equals($time3));
    }
}
