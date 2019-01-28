<?php

namespace Domain\Education\StudentGroup\Event;

use Domain\Date;
use Domain\DomainEvent;
use Domain\Contract\IdentifiesAggregate;
use Domain\Education\StudentGroup\Schedule;
use Domain\Education\StudentGroup\StudentGroupId;

class StudentGroupScheduleWasChanged extends DomainEvent
{
    /**
     * @var StudentGroupId
     */
    private $studentGroupId;

    /**
     * @var Schedule
     */
    private $schedule;

    /**
     * @var Date
     */
    private $changedOn;

    /**
     * StudentGroupScheduleWasChanged constructor.
     * @param StudentGroupId $studentGroupId
     * @param Schedule $schedule
     * @param Date $changedOn
     */
    public function __construct(StudentGroupId $studentGroupId, Schedule $schedule, Date $changedOn)
    {
        $this->studentGroupId = $studentGroupId;
        $this->schedule = $schedule;
        $this->changedOn = $changedOn;
    }

    /**
     * The Aggregate this event belongs to.
     * @return IdentifiesAggregate
     */
    public function getAggregateId()
    {
        return $this->studentGroupId;
    }

    /**
     * @return Schedule
     */
    public function schedule()
    {
        return $this->schedule;
    }

    /**
     * @return Date
     */
    public function changedOn(): Date
    {
        return $this->changedOn;
    }

    /**
     * @return mixed
     */
    public function data(): array
    {
        return [
            'schedule' => (string)$this->schedule,
            'changed_on' => (string)$this->changedOn,
        ];
    }

    /**
     * @param $data
     * @return \Domain\Contract\DomainEvent
     */
    public static function rebuildFromData($data): \Domain\Contract\DomainEvent
    {
        return new self(
            StudentGroupId::fromString($data->aggregate_id),
            Schedule::fromString($data->schedule),
            Date::fromString($data->changed_on)
        );
    }
}
