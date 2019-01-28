<?php

namespace Tests\Unit\Domain\Schedule;

use Domain\Education\StudentGroup\Schedule\GroupClassDuration;
use PHPUnit\Framework\TestCase;

class GroupClassDurationTest extends TestCase
{
    public function test_equals()
    {
        $duration1 = new GroupClassDuration(1);
        $duration2 = new GroupClassDuration(1);
        $duration3 = new GroupClassDuration(5);

        $this->assertTrue($duration1->equals($duration2));
        $this->assertFalse($duration1->equals($duration3));
    }
}
