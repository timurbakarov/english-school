<?php

namespace Tests\Unit\Domain\Schedule;

use Domain\Education\StudentGroup\Schedule\DayOfWeek;
use PHPUnit\Framework\TestCase;

class DayOfWeekTest extends TestCase
{
    public function test_equals()
    {
        $dayOfWeek1 = new DayOfWeek(1);
        $dayOfWeek2 = new DayOfWeek(1);
        $dayOfWeek3 = new DayOfWeek(5);

        $this->assertTrue($dayOfWeek1->equals($dayOfWeek2));
        $this->assertFalse($dayOfWeek1->equals($dayOfWeek3));
    }
}
