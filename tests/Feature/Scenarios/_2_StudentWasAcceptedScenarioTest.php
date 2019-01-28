<?php

namespace Tests\Feature\Scenarios;

use Infr\TestServices;
use PHPUnit\Framework\TestCase;
use Domain\HumanResource\Student;
use Domain\StudentId;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\HumanResource\Student\Event\StudentWasAccepted;
use Domain\HumanResource\Student\Command\AcceptStudentCommand;
use Domain\HumanResource\Student\Command\AcceptStudentHandler;

class _2_StudentWasAcceptedScenarioTest extends TestCase
{
    public function test_accept_student()
    {
        $testServices = new TestServices([
            StudentId::class => Student::class,
        ]);

        $studentGroupId = StudentGroupId::generate();

        $command = new AcceptStudentCommand(
            'John',
            'Doe',
            (string)$studentGroupId,
            'test@example.com',
            '+79524261442',
            '2018-10-12',
            'Parents'
        );
        $handler = new AcceptStudentHandler($testServices->repository(), $testServices->eventDispatcher());

        $studentId = $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentId);

        /** @var StudentWasAccepted $event */
        $event = $aggregateHistory[0];

        $this->assertEquals(1, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentWasAccepted::class, $event);
        $this->assertEquals($studentId->toString(), $event->getAggregateId());
        $this->assertEquals([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'group_id' => (string)$studentGroupId,
            'email' => 'test@example.com',
            'phone' => '+79524261442',
            'accepted_date' => '2018-10-12',
            'parents' => 'Parents'
        ], $event->data());
    }
}
