<?php

namespace Domain\HumanResource\Student\Event;

use Domain\StudentId;
use Domain\DomainEvent;
use Domain\HumanResource\Student\Name;
use Domain\Contract\IdentifiesAggregate;

class StudentNameWasChanged extends DomainEvent
{
    /**
     * @var StudentId
     */
    private $studentId;

    /**
     * @var Name
     */
    private $name;

    /**
     * @param StudentId $studentId
     * @param Name|NULL $name
     */
    public function __construct(StudentId $studentId, Name $name = null)
    {
        $this->studentId = $studentId;
        $this->name = $name;
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
     * @return Name|NULL
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function data(): array
    {
        return [
            'first_name' => $this->name->first(),
            'last_name' => $this->name->last(),
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
            new Name($data->first_name, $data->last_name)
        );
    }
}
