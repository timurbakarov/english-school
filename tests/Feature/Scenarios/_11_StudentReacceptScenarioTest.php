<?php

namespace Tests\Feature\Scenarios;

use Domain\Date;
use Domain\Email;
use Domain\Phone;
use Domain\StudentId;
use Infr\TestServices;
use Domain\DomainEvents;
use PHPUnit\Framework\TestCase;
use Domain\HumanResource\Student\Name;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\HumanResource\Student\Event\StudentWasAccepted;
use Domain\HumanResource\Student\Event\StudentWasDismissed;
use Domain\HumanResource\Student\Event\StudentWasReaccepted;
use Domain\HumanResource\Student\Command\ReacceptStudentCommand;
use Domain\HumanResource\Student\Command\ReacceptStudentHandler;

class _11_StudentReacceptScenarioTest extends TestCase
{
    public function test_student_reaccept()
    {
        $testServices = new TestServices();

        $studentId = StudentId::generate();
        $studentGroupId = StudentGroupId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            new StudentWasAccepted(
                $studentId,
                StudentGroupId::generate(),
                new Name('test', 'qwert'),
                new Email('test@mail.ru'),
                new Phone('+79521234567'),
                Date::now(),
                ''
            ),
            new StudentWasDismissed($studentId, $studentGroupId, Date::now())
        ]));

        $command = new ReacceptStudentCommand((string)$studentId, (string)$studentGroupId, Date::now());
        $handler = new ReacceptStudentHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentId);

        /** @var StudentWasReaccepted $event */
        $event = $aggregateHistory[2];

        $this->assertEquals(3, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentWasReaccepted::class, $event);
        $this->assertEquals((string)$studentId, $event->getAggregateId());
        $this->assertEquals([
            'group_id' => (string)$studentGroupId,
            'reaccepted_on' => (string)Date::now(),
        ], $event->data());
    }

    public function test_can_not_be_reaccepted_earlier_than_was_dismissed()
    {
        $this->expectExceptionMessage('Can not be reaccepted earlier than was dismissed');

        $testServices = new TestServices();

        $studentId = StudentId::generate();
        $studentGroupId = StudentGroupId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            new StudentWasAccepted(
                $studentId,
                StudentGroupId::generate(),
                new Name('test', 'qwert'),
                new Email('test@mail.ru'),
                new Phone('+79521234567'),
                Date::now(),
                ''
            ),
            new StudentWasDismissed($studentId, $studentGroupId, Date::fromString('2018-10-12'))
        ]));

        $command = new ReacceptStudentCommand((string)$studentId, (string)$studentGroupId, Date::fromString('2018-10-10'));
        $handler = new ReacceptStudentHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $handler->handle($command);
    }
}
