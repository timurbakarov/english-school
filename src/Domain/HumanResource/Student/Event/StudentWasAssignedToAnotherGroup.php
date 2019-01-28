<?php

namespace Domain\HumanResource\Student\Event;

use Domain\Date;
use Domain\StudentId;
use Domain\DomainEvent;
use Domain\Contract\IdentifiesAggregate;
use Domain\Education\StudentGroup\StudentGroupId;

class StudentWasAssignedToAnotherGroup extends DomainEvent
{
    /**
     * @var StudentId
     */
    private $studentId;

    /**
     * @var StudentGroupId
     */
    private $studentGroupFromId;

    /**
     * @var StudentGroupId
     */
    private $studentGroupToId;

    /**
     * @var Date
     */
    private $assignedOn;

    /**
     * @param StudentId $studentId
     * @param StudentGroupId $studentGroupFromId
     * @param StudentGroupId $studentGroupToId
     * @param Date $assignedOn
     */
    public function __construct(StudentId $studentId, StudentGroupId $studentGroupFromId, StudentGroupId $studentGroupToId, Date $assignedOn)
    {
        $this->studentId = $studentId;
        $this->studentGroupFromId = $studentGroupFromId;
        $this->studentGroupToId = $studentGroupToId;
        $this->assignedOn = $assignedOn;
    }

    /**
     * The Aggregate this event belongs to.
     * @return IdentifiesAggregate
     */
    public function getAggregateId()
    {
        return $this->studentId;
    }

    /**
     * @return StudentGroupId
     */
    public function studentGroupFromId(): StudentGroupId
    {
        return $this->studentGroupFromId;
    }

    /**
     * @return StudentGroupId
     */
    public function studentGroupToId(): StudentGroupId
    {
        return $this->studentGroupToId;
    }

    /**
     * @return Date
     */
    public function assignedOn()
    {
        return $this->assignedOn;
    }

    /**
     * @return mixed
     */
    public function data(): array
    {
        return [
            'group_from_id' => (string)$this->studentGroupFromId,
            'group_to_id' => (string)$this->studentGroupToId,
            'assigned_on' => (string)$this->assignedOn,
        ];
    }

    /**
     * @param $data
     * @return \Domain\Contract\DomainEvent
     */
    public static function rebuildFromData($data): \Domain\Contract\DomainEvent
    {
        return new self(
            StudentId::fromString($data->aggregate_id),
            StudentGroupId::fromString($data->group_from_id),
            StudentGroupId::fromString($data->group_to_id),
            Date::fromString($data->assigned_on)
        );
    }
}
