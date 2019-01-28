<?php

namespace Tests\Unit\Domain;

use Domain\Exception\InvalidArgumentException;
use Domain\Time;
use Domain\TimeInterval;
use PHPUnit\Framework\TestCase;

class TimeIntervalTest extends TestCase
{
    public function test_init_from_begin_and_end_times()
    {
        $this->expectException(InvalidArgumentException::class);

        new TimeInterval(new Time(11, 0), new Time(10, 0));
    }

    public function test_time_interval_overlap()
    {
        $timeInterval = TimeInterval::fromTimeAndDuration(new Time(10, 30), 1);

        $this->assertTrue($timeInterval->isOverlapped(TimeInterval::fromTimeAndDuration(new Time(10, 30), 1)));
        $this->assertTrue($timeInterval->isOverlapped(TimeInterval::fromTimeAndDuration(new Time(11, 00), 1)));
        $this->assertTrue($timeInterval->isOverlapped(TimeInterval::fromTimeAndDuration(new Time(11, 15), 1)));
        $this->assertTrue($timeInterval->isOverlapped(TimeInterval::fromTimeAndDuration(new Time(9, 45), 1)));


        $this->assertFalse($timeInterval->isOverlapped(TimeInterval::fromTimeAndDuration(new Time(9, 30), 1)));
        $this->assertFalse($timeInterval->isOverlapped(TimeInterval::fromTimeAndDuration(new Time(9, 44), 1)));
        $this->assertFalse($timeInterval->isOverlapped(TimeInterval::fromTimeAndDuration(new Time(11, 16), 1)));
        $this->assertFalse($timeInterval->isOverlapped(TimeInterval::fromTimeAndDuration(new Time(11, 30), 1)));
    }

    public function test_time_interval_to_string()
    {
        $timeInterval = TimeInterval::fromTimeAndDuration(new Time(10, 30), 1);
        $this->assertEquals('10:30 - 11:15', (string)$timeInterval);

        $timeInterval = TimeInterval::fromTimeAndDuration(new Time(10, 30), 2);
        $this->assertEquals('10:30 - 12:00', (string)$timeInterval);
    }

    public function test_duration_lower_than_1()
    {
        $this->expectException(InvalidArgumentException::class);

        TimeInterval::fromTimeAndDuration(new Time(0, 30), -1);
    }
}
