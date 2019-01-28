<?php

namespace Tests\Feature\Scenarios;

use Domain\Date;
use Domain\DomainEvents;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\Email;
use Domain\HumanResource\Student\Event\StudentWasAccepted;
use Domain\HumanResource\Student\Name;
use Domain\Phone;
use Infr\TestServices;
use PHPUnit\Framework\TestCase;
use Domain\HumanResource\Student;
use Domain\StudentId;

class _3_StudentDismissScenarionTest extends TestCase
{
    public function test_dismiss_student()
    {
        $testServices = new TestServices();

        $studentId = StudentId::generate();
        $studentGroupId = StudentGroupId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            new StudentWasAccepted(
                $studentId,
                $studentGroupId,
                new Name('test', 'qwert'),
                new Email('test@mail.ru'),
                new Phone('+79521234567'),
                Date::fromString('2018-10-12'),
                ''
            ),
        ]));

        $command = new Student\Command\DismissStudentCommand((string)$studentId, Date::fromString('2018-10-12'), 'Reason');
        $handler = new Student\Command\DismissStudentHandler($testServices->repository(), $testServices->eventDispatcher());

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentId);

        /** @var Student\Event\StudentWasDismissed $event */
        $event = $aggregateHistory[1];

        $this->assertEquals(2, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(Student\Event\StudentWasDismissed::class, $event);
        $this->assertEquals($studentId->toString(), $event->getAggregateId());
        $this->assertEquals([
            'group_id' => (string)$studentGroupId,
            'dismissed_on' => '2018-10-12',
            'reason' => 'Reason',
        ], $event->data());
    }

    public function test_if_was_already_dismissed_skip_actions()
    {
        $testServices = new TestServices();

        $studentId = StudentId::generate();
        $studentGroupId = StudentGroupId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            new Student\Event\StudentWasDismissed(
                $studentId,
                $studentGroupId,
                Date::now()
            )
        ]));

        $command = new Student\Command\DismissStudentCommand((string)$studentId, Date::fromString('2018-10-12'), 'Reason');
        $handler = new Student\Command\DismissStudentHandler($testServices->repository(), $testServices->eventDispatcher());

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentId);

        $this->assertEquals(1, count($aggregateHistory));
        $this->assertEquals(0, $testServices->eventDispatcher()->count());
    }

    public function test_can_not_be_dismissed_earlier_than_was_accepted()
    {
        $this->expectExceptionMessage('Can not be dismissed earlier than was accepted');

        $testServices = new TestServices();

        $studentId = StudentId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            new StudentWasAccepted(
                $studentId,
                StudentGroupId::generate(),
                new Name('test', 'qwert'),
                new Email('test@mail.ru'),
                new Phone('+79521234567'),
                Date::fromString('2018-10-12'),
                ''
            ),
        ]));

        $command = new Student\Command\DismissStudentCommand((string)$studentId, Date::fromString('2018-10-10'), 'Reason');
        $handler = new Student\Command\DismissStudentHandler($testServices->repository(), $testServices->eventDispatcher());

        $handler->handle($command);
    }
}
