<?php

namespace Domain\Education\StudentGroup\Event;

use Domain\Date;
use Domain\DomainEvent;
use Domain\Contract\IdentifiesAggregate;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\Education\StudentGroup\StudentGroupName;

class StudentGroupNameWasChanged extends DomainEvent
{
    /**
     * @var StudentGroupId
     */
    private $studentGroupId;

    /**
     * @var StudentGroupName
     */
    private $name;

    /**
     * @var Date
     */
    private $changedOn;

    /**
     * StudentGroupNameWasChanged constructor.
     * @param StudentGroupId $studentGroupId
     * @param StudentGroupName $name
     * @param Date $changedOn
     */
    public function __construct(StudentGroupId $studentGroupId, StudentGroupName $name, Date $changedOn)
    {
        $this->studentGroupId = $studentGroupId;
        $this->name = $name;
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
     * @return StudentGroupName
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return Date
     */
    public function changedOn()
    {
        return $this->changedOn;
    }

    /**
     * @return mixed
     */
    public function data(): array
    {
        return [
            'name' => (string)$this->name,
            'changed_on' => (string)$this->changedOn,
        ];
    }

    /**
     * @param $data
     * @return \Domain\Contract\DomainEvent
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public static function rebuildFromData($data): \Domain\Contract\DomainEvent
    {
        return new self(
            StudentGroupId::fromString($data->aggregate_id),
            new StudentGroupName($data->name),
            Date::fromString($data->changed_on)
        );
    }
}
