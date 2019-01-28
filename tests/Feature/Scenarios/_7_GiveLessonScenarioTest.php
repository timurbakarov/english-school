<?php

namespace Tests\Feature\Scenarios;

use Domain\Date;
use Infr\TestServices;
use Domain\DomainEvents;
use PHPUnit\Framework\TestCase;
use Domain\Education\StudentGroup\Schedule;
use Domain\Education\StudentGroup\PricePerHour;
use Domain\Education\Lesson\Event\LessonWasGiven;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\Education\StudentGroup\StudentGroupName;
use Domain\Education\Lesson\Command\GiveLessonCommand;
use Domain\Education\Lesson\Command\GiveLessonHandler;
use Domain\Education\StudentGroup\Event\StudentGroupWasCreated;

class _7_GiveLessonScenarioTest extends TestCase
{
    public function test_give_lesson()
    {
        $testServices = new TestServices();

        $studentGroupId = StudentGroupId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            new StudentGroupWasCreated(
                $studentGroupId,
                new Schedule(
                    new Schedule\ScheduleItem(
                        new Schedule\DayOfWeek(1), new Schedule\ScheduleTime(10, 30), new Schedule\GroupClassDuration(1)
                    )
                ),
                new StudentGroupName('Name'),
                new PricePerHour(300),
                Date::now()
            )
        ]));

        $command = new GiveLessonCommand(
            (string)$studentGroupId,
            '2018-10-12',
            '10:30',
            2
        );
        $handler = new GiveLessonHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $lessonId = $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($lessonId);

        /** @var LessonWasGiven $event */
        $event = $aggregateHistory[0];

        $this->assertEquals(1, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(LessonWasGiven::class, $event);
        $this->assertEquals((string)$lessonId, $event->getAggregateId());
        $this->assertEquals([
            'group_id' => (string)$studentGroupId,
            'date' => '2018-10-12',
            'time' => '10:30',
            'price_per_hour' => '300',
            'duration' => '2',
        ], $event->data());
    }
}
