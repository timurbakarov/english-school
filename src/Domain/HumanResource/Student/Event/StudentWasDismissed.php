<?php

namespace Domain\HumanResource\Student\Event;

use Domain\Date;
use Domain\StudentId;
use Domain\DomainEvent;
use Domain\Contract\IdentifiesAggregate;
use Domain\Education\StudentGroup\StudentGroupId;

class StudentWasDismissed extends DomainEvent
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
    private $dismissedOn;

    /**
     * @var string
     */
    private $reason;

    /**
     * @param StudentId $studentId
     * @param StudentGroupId $studentGroupId
     * @param Date $dismissedOn
     * @param string $reason
     */
    public function __construct(StudentId $studentId, StudentGroupId $studentGroupId, Date $dismissedOn, string $reason = null)
    {
        $this->studentId = $studentId;
        $this->studentGroupId = $studentGroupId;
        $this->dismissedOn = $dismissedOn;
        $this->reason = $reason;
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
    public function studentGroupId()
    {
        return $this->studentGroupId;
    }

    /**
     * @return Date
     */
    public function dismissedOn(): Date
    {
        return $this->dismissedOn;
    }

    /**
     * @return string
     */
    public function reason(): string
    {
        return $this->reason;
    }

    /**
     * @return mixed
     */
    public function data(): array
    {
        return [
            'group_id' => (string)$this->studentGroupId,
            'dismissed_on' => (string)$this->dismissedOn,
            'reason' => $this->reason,
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
            Date::fromString($data->dismissed_on),
            $data->reason
        );
    }
}
