<?php

namespace Tests\Feature\Scenarios;

use Domain\Date;
use Domain\Email;
use Domain\Phone;
use Domain\StudentId;
use Infr\TestServices;
use Domain\DomainEvents;
use PHPUnit\Framework\TestCase;
use Domain\HumanResource\Student;
use Domain\Education\StudentGroup;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\HumanResource\Student\Event\StudentWasAccepted;
use Domain\HumanResource\Student\Event\StudentWasAssignedToAnotherGroup;
use Domain\HumanResource\Student\Command\MoveStudentToAnotherGroupCommand;
use Domain\HumanResource\Student\Command\MoveStudentToAnotherGroupHandler;

class _4_StudentMovedToAnotherGroupScenarioTest extends TestCase
{
    public function test_move_to_another_group()
    {
        $testServices = new TestServices();

        $studentId = StudentId::generate();
        $groupFromId = StudentGroupId::generate();
        $groupId = StudentGroupId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            new StudentWasAccepted(
                $studentId,
                $groupFromId,
                new Student\Name('John', 'Doe'),
                new Email('test@example.com'),
                new Phone('+79501234567'),
                Date::now()
            )
        ]));

        $dummyStudentGroupSearcher = new DummyStudentGroupSearcher(true, true);

        $studentGroupIsAssignableSpec = new StudentGroup\Specification\StudentGroupAssignableSpec(
            new StudentGroup\Specification\StudentGroupActiveSpec($dummyStudentGroupSearcher),
            new StudentGroup\Specification\StudentGroupExistsSpec($dummyStudentGroupSearcher)
        );

        $command = new MoveStudentToAnotherGroupCommand($studentId->toString(), $groupId->toString(), '2018-10-12');
        $handler = new MoveStudentToAnotherGroupHandler(
            $testServices->repository(),
            $testServices->eventDispatcher(),
            $studentGroupIsAssignableSpec
        );

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentId);

        /** @var StudentWasAssignedToAnotherGroup $event */
        $event = $aggregateHistory[1];

        $this->assertEquals(2, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentWasAssignedToAnotherGroup::class, $event);
        $this->assertEquals($studentId->toString(), $event->getAggregateId());
        $this->assertEquals([
            'group_from_id' => (string)$groupFromId,
            'group_to_id' => (string)$groupId,
            'assigned_on' => '2018-10-12',
        ], $event->data());
    }

    public function test_dont_move_to_same_group()
    {
        $testServices = new TestServices();

        $studentId = StudentId::generate();
        $groupId = StudentGroupId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            new StudentWasAccepted(
                $studentId,
                $groupId,
                new Student\Name('John', 'Doe'),
                new Email('test@example.com'),
                new Phone('+79501234567'),
                Date::now()
            )
        ]));

        $dummyStudentGroupSearcher = new DummyStudentGroupSearcher(true, true);

        $studentGroupIsAssignableSpec = new StudentGroup\Specification\StudentGroupAssignableSpec(
            new StudentGroup\Specification\StudentGroupActiveSpec($dummyStudentGroupSearcher),
            new StudentGroup\Specification\StudentGroupExistsSpec($dummyStudentGroupSearcher)
        );

        $command = new MoveStudentToAnotherGroupCommand($studentId->toString(), $groupId->toString(), '2018-10-12');
        $handler = new MoveStudentToAnotherGroupHandler(
            $testServices->repository(),
            $testServices->eventDispatcher(),
            $studentGroupIsAssignableSpec
        );

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentId);

        $this->assertEquals(1, count($aggregateHistory));
        $this->assertEquals(0, $testServices->eventDispatcher()->count());
    }

    public function test_throw_exception_if_group_does_not_exist()
    {
        $this->expectException(StudentGroup\Exception\StudentGroupIsNotAssignable::class);

        $testServices = new TestServices();

        $studentId = StudentId::generate();
        $groupId = StudentGroupId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            new StudentWasAccepted(
                $studentId,
                $groupId,
                new Student\Name('John', 'Doe'),
                new Email('test@example.com'),
                new Phone('+79501234567'),
                Date::now()
            )
        ]));

        $dummyStudentGroupSearcher = new DummyStudentGroupSearcher(false, true);

        $studentGroupIsAssignableSpec = new StudentGroup\Specification\StudentGroupAssignableSpec(
            new StudentGroup\Specification\StudentGroupActiveSpec($dummyStudentGroupSearcher),
            new StudentGroup\Specification\StudentGroupExistsSpec($dummyStudentGroupSearcher)
        );

        $command = new MoveStudentToAnotherGroupCommand($studentId->toString(), StudentGroupId::generate(), '2018-10-12');
        $handler = new MoveStudentToAnotherGroupHandler(
            $testServices->repository(),
            $testServices->eventDispatcher(),
            $studentGroupIsAssignableSpec
        );

        $handler->handle($command);
    }

    public function test_throw_exception_if_group_is_not_active()
    {
        $this->expectException(StudentGroup\Exception\StudentGroupIsNotAssignable::class);

        $testServices = new TestServices();

        $studentId = StudentId::generate();
        $groupId = StudentGroupId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            new StudentWasAccepted(
                $studentId,
                $groupId,
                new Student\Name('John', 'Doe'),
                new Email('test@example.com'),
                new Phone('+79501234567'),
                Date::now()
            )
        ]));

        $dummyStudentGroupSearcher = new DummyStudentGroupSearcher(true, false);

        $studentGroupIsAssignableSpec = new StudentGroup\Specification\StudentGroupAssignableSpec(
            new StudentGroup\Specification\StudentGroupActiveSpec($dummyStudentGroupSearcher),
            new StudentGroup\Specification\StudentGroupExistsSpec($dummyStudentGroupSearcher)
        );

        $command = new MoveStudentToAnotherGroupCommand($studentId->toString(), StudentGroupId::generate(), '2018-10-12');
        $handler = new MoveStudentToAnotherGroupHandler(
            $testServices->repository(),
            $testServices->eventDispatcher(),
            $studentGroupIsAssignableSpec
        );

        $handler->handle($command);
    }

    public function test_throw_exception_if_student_is_dismissed()
    {
        $this->expectException(Student\Exception\StudentIsDismissedException::class);

        $testServices = new TestServices();

        $studentId = StudentId::generate();
        $groupId = StudentGroupId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            new StudentWasAccepted(
                $studentId,
                $groupId,
                new Student\Name('John', 'Doe'),
                new Email('test@example.com'),
                new Phone('+79501234567'),
                Date::now()
            ),
            new Student\Event\StudentWasDismissed(
                $studentId,
                $groupId,
                Date::now()
            )
        ]));

        $dummyStudentGroupSearcher = new DummyStudentGroupSearcher(true, false);

        $studentGroupIsAssignableSpec = new StudentGroup\Specification\StudentGroupAssignableSpec(
            new StudentGroup\Specification\StudentGroupActiveSpec($dummyStudentGroupSearcher),
            new StudentGroup\Specification\StudentGroupExistsSpec($dummyStudentGroupSearcher)
        );

        $command = new MoveStudentToAnotherGroupCommand($studentId->toString(), StudentGroupId::generate(), '2018-10-12');
        $handler = new MoveStudentToAnotherGroupHandler(
            $testServices->repository(),
            $testServices->eventDispatcher(),
            $studentGroupIsAssignableSpec
        );

        $handler->handle($command);
    }
}

class DummyStudentGroupSearcher implements StudentGroup\StudentGroupSearcher
{
    /**
     * @var bool
     */
    private $exists;

    /**
     * @var bool
     */
    private $isActive;

    /**
     * @param bool $exists
     * @param bool $isActive
     */
    public function __construct(bool $exists, bool $isActive)
    {
        $this->exists = $exists;
        $this->isActive = $isActive;
    }

    /**
     * @param StudentGroupId $studentGroupId
     * @return bool
     */
    public function exists(StudentGroupId $studentGroupId): bool
    {
        return $this->exists;
    }

    /**
     * @param StudentGroupId $studentGroupId
     * @return bool
     */
    public function isActive(StudentGroupId $studentGroupId): bool
    {
        return $this->isActive;
    }
}
