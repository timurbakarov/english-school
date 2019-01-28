<?php

namespace Tests\Feature\Scenarios;

use Domain\HumanResource\Student\Event\StudentNameWasChanged;
use Domain\StudentId;
use Infr\TestServices;
use Domain\DomainEvents;
use PHPUnit\Framework\TestCase;
use Domain\HumanResource\Student\Event\StudentWasAccepted;
use Domain\HumanResource\Student\Command\UpdateStudentNameCommand;
use Domain\HumanResource\Student\Command\UpdateStudentNameHandler;

class _13_UpdateStudentProfileScenarioTest extends TestCase
{
    public function test_profile_name_updated()
    {
        $testServices = new TestServices();

        $studentId = StudentId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            StudentWasAccepted::forTest($studentId),
        ]));

        $command = new UpdateStudentNameCommand((string)$studentId, 'John1', 'Doe1');
        $handler = new UpdateStudentNameHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentId);

        /** @var StudentNameWasChanged $event */
        $event = $aggregateHistory[1];

        $this->assertEquals(2, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentNameWasChanged::class, $event);
        $this->assertEquals((string)$studentId, $event->getAggregateId());
        $this->assertEquals([
            'first_name' => 'John1',
            'last_name' => 'Doe1',
        ], $event->data());
    }
}
