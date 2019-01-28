<?php

namespace Tests\Feature\Scenarios;

use Domain\Date;
use Infr\TestServices;
use Domain\DomainEvents;
use Domain\Contract\EventStore;
use PHPUnit\Framework\TestCase;
use Domain\Education\StudentGroup;
use Domain\Education\StudentGroup\Event\StudentGroupWasCreated;
use Domain\Education\StudentGroup\Command\CreateStudentGroupCommand;
use Domain\Education\StudentGroup\Command\CreateStudentGroupHandler;

class _1_StudentGroupScenariosTest extends TestCase
{
    public function test_student_group_created()
    {
        $testServices = new TestServices();

        $schedule = new StudentGroup\Schedule(
            new StudentGroup\Schedule\ScheduleItem(
                new StudentGroup\Schedule\DayOfWeek(1),
                new StudentGroup\Schedule\ScheduleTime(10, 0),
                new StudentGroup\Schedule\GroupClassDuration(1)
            )
        );

        $command = new CreateStudentGroupCommand('Group name', $schedule, 300, '2018-10-12');
        $handler = new CreateStudentGroupHandler($testServices->repository(), $testServices->eventDispatcher());

        $studentGroupId = $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentGroupId);

        /** @var StudentGroupWasCreated $studentWasCreatedEvent */
        $event = $aggregateHistory[0];

        $this->assertEquals(1, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentGroupWasCreated::class, $event);
        $this->assertEquals($studentGroupId->toString(), $event->getAggregateId());
        $this->assertEquals([
            'name' => 'Group name',
            'schedule' => '1,10:00,1',
            'price_per_hour' => 300,
            'created_on' => '2018-10-12',
        ], $event->data());
    }

    public function test_name_changed()
    {
        $testServices = new TestServices();

        $studentGroupId = StudentGroup\StudentGroupId::generate();

        $this->addCreateGroupEvent($testServices->eventStore(), $studentGroupId);

        $command = new StudentGroup\Command\ChangeStudentGroupNameCommand($studentGroupId, 'New group name', '2018-10-12');
        $handler = new StudentGroup\Command\ChangeStudentGroupNameHandler($testServices->repository(), $testServices->eventDispatcher());

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentGroupId);

        /** @var StudentGroupWasCreated $studentWasCreatedEvent */
        $event = $aggregateHistory[1];

        $this->assertEquals(2, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentGroup\Event\StudentGroupNameWasChanged::class, $event);
        $this->assertEquals($studentGroupId->toString(), $event->getAggregateId());
        $this->assertEquals([
            'name' => 'New group name',
            'changed_on' => '2018-10-12',
        ], $event->data());
    }

    public function test_same_name_change_dont_create_event()
    {
        $testServices = new TestServices();

        $studentGroupId = StudentGroup\StudentGroupId::generate();

        $this->addCreateGroupEvent($testServices->eventStore(), $studentGroupId);

        $command = new StudentGroup\Command\ChangeStudentGroupNameCommand($studentGroupId, 'Group name', '2018-10-12');
        $handler = new StudentGroup\Command\ChangeStudentGroupNameHandler($testServices->repository(), $testServices->eventDispatcher());

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentGroupId);

        $this->assertEquals(1, count($aggregateHistory));
    }

    public function test_schedule_changed()
    {
        $testServices = new TestServices();

        $studentGroupId = StudentGroup\StudentGroupId::generate();

        $this->addCreateGroupEvent($testServices->eventStore(), $studentGroupId);

        $newSchedule = new StudentGroup\Schedule(
            new StudentGroup\Schedule\ScheduleItem(
                new StudentGroup\Schedule\DayOfWeek(2),
                new StudentGroup\Schedule\ScheduleTime(10, 0),
                new StudentGroup\Schedule\GroupClassDuration(1)
            )
        );

        $command = new StudentGroup\Command\ChangeStudentGroupScheduleCommand($studentGroupId, $newSchedule);
        $handler = new StudentGroup\Command\ChangeStudentGroupScheduleHandler($testServices->repository(), $testServices->eventDispatcher());

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentGroupId);

        /** @var StudentGroupWasCreated $studentWasCreatedEvent */
        $event = $aggregateHistory[1];

        $this->assertEquals(2, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentGroup\Event\StudentGroupScheduleWasChanged::class, $event);
        $this->assertEquals($studentGroupId->toString(), $event->getAggregateId());
        $this->assertEquals([
            'schedule' => '2,10:00,1',
            'changed_on' => (string)Date::now(),
        ], $event->data());
    }

    public function test_same_schedule_change_dont_create_event()
    {
        $testServices = new TestServices();

        $studentGroupId = StudentGroup\StudentGroupId::generate();

        $this->addCreateGroupEvent($testServices->eventStore(), $studentGroupId);

        $newSchedule = new StudentGroup\Schedule(
            new StudentGroup\Schedule\ScheduleItem(
                new StudentGroup\Schedule\DayOfWeek(1),
                new StudentGroup\Schedule\ScheduleTime(10, 0),
                new StudentGroup\Schedule\GroupClassDuration(1)
            )
        );

        $command = new StudentGroup\Command\ChangeStudentGroupScheduleCommand($studentGroupId, $newSchedule);
        $handler = new StudentGroup\Command\ChangeStudentGroupScheduleHandler($testServices->repository(), $testServices->eventDispatcher());

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentGroupId);

        $this->assertEquals(1, count($aggregateHistory));
        $this->assertEquals(0, $testServices->eventDispatcher()->count());
    }

    public function test_price_per_hour_changed()
    {
        $testServices = new TestServices();

        $studentGroupId = StudentGroup\StudentGroupId::generate();

        $this->addCreateGroupEvent($testServices->eventStore(), $studentGroupId);

        $command = new StudentGroup\Command\ChangeStudentGroupPricePerHourCommand($studentGroupId, 1000);
        $handler = new StudentGroup\Command\ChangeStudentGroupPricePerHourHandler($testServices->repository(), $testServices->eventDispatcher());

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentGroupId);

        /** @var StudentGroupWasCreated $studentWasCreatedEvent */
        $event = $aggregateHistory[1];

        $this->assertEquals(2, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentGroup\Event\StudentGroupPricePerHourWasChanged::class, $event);
        $this->assertEquals($studentGroupId->toString(), $event->getAggregateId());
        $this->assertEquals([
            'price_per_hour' => '1000',
            'changed_on' => (string)Date::now(),
        ], $event->data());
    }

    public function test_price_per_hour_change_dont_create_event()
    {
        $testServices = new TestServices();

        $studentGroupId = StudentGroup\StudentGroupId::generate();

        $this->addCreateGroupEvent($testServices->eventStore(), $studentGroupId);

        $command = new StudentGroup\Command\ChangeStudentGroupPricePerHourCommand($studentGroupId, 300);
        $handler = new StudentGroup\Command\ChangeStudentGroupPricePerHourHandler($testServices->repository(), $testServices->eventDispatcher());

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentGroupId);

        $this->assertEquals(1, count($aggregateHistory));
        $this->assertEquals(0, $testServices->eventDispatcher()->count());
    }

    /**
     * @param EventStore $eventStore
     * @param $studentGroupId
     * @throws \Domain\Exception\InvalidArgumentException
     */
    private function addCreateGroupEvent(EventStore $eventStore, $studentGroupId)
    {
        $eventStore->commit(new DomainEvents([
            new StudentGroupWasCreated(
                $studentGroupId,
                new StudentGroup\Schedule(
                    new StudentGroup\Schedule\ScheduleItem(
                        new StudentGroup\Schedule\DayOfWeek(1),
                        new StudentGroup\Schedule\ScheduleTime(10, 0),
                        new StudentGroup\Schedule\GroupClassDuration(1)
                    )
                ),
                new StudentGroup\StudentGroupName('Group name'),
                new StudentGroup\PricePerHour(300),
                Date::fromString('2018-10-12')
            )
        ]));
    }
}
