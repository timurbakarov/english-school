<?php

namespace Tests\Unit\Domain;

use Domain\Exception\InvalidArgumentException;
use Domain\Time;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    public function test_create_from_minutes()
    {
        $time = Time::fromMinutes(30);
        $this->assertEquals('0:30', (string)$time);

        $time = Time::fromMinutes(150);
        $this->assertEquals('2:30', (string)$time);

    }

    public function test_convert_to_minutes()
    {
        $time = new Time(0, 30);
        $this->assertEquals(30, $time->convertToMinutes());

        $time = new Time(2, 30);
        $this->assertEquals(150, $time->convertToMinutes());
    }

    public function test_to_string()
    {
        $time = new Time(10, 30);
        $this->assertEquals('10:30', (string)$time);

        $time = new Time(0, 30);
        $this->assertEquals('0:30', (string)$time);

        $time = new Time(0, 5);
        $this->assertEquals('0:05', (string)$time);
    }

    public function test_hour_max_edge_case()
    {
        $this->expectException(InvalidArgumentException::class);

        new Time(24, 30);
    }

    public function test_hour_min_edge_case()
    {
        $this->expectException(InvalidArgumentException::class);

        new Time(-1, 0);
    }

    public function test_minutes_max_edge_case()
    {
        $this->expectException(InvalidArgumentException::class);

        new Time(10, 60);
    }

    public function test_minutes_min_edge_case()
    {
        $this->expectException(InvalidArgumentException::class);

        new Time(10, -10);
    }
}
