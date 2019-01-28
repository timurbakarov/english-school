<?php

namespace Domain\HumanResource\Student\Event;

use Domain\Contract\IdentifiesAggregate;
use Domain\Date;
use Domain\DomainEvent;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\StudentId;

class StudentWasReaccepted extends DomainEvent
{
    /**
     * @var StudentId
     */
    private $studentId;

    /**
     * @var StudentGroupId
     */
    private $studentGroupId;

    /**
     * @var Date
     */
    private $reacceptedOn;

    /**
     * @param StudentId $studentId
     * @param StudentGroupId $studentGroupId
     * @param Date $reacceptedOn
     */
    public function __construct(StudentId $studentId, StudentGroupId $studentGroupId, Date $reacceptedOn)
    {
        $this->studentId = $studentId;
        $this->studentGroupId = $studentGroupId;
        $this->reacceptedOn = $reacceptedOn;
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
    public function studentGroupId(): StudentGroupId
    {
        return $this->studentGroupId;
    }

    /**
     * @return Date
     */
    public function reacceptedOn()
    {
        return $this->reacceptedOn;
    }

    /**
     * @return mixed
     */
    public function data(): array
    {
        return [
            'group_id' => (string)$this->studentGroupId,
            'reaccepted_on' => (string)$this->reacceptedOn,
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
            StudentGroupId::fromString($data->group_id),
            Date::fromString($data->reaccepted_on)
        );
    }
}
