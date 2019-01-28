<?php

namespace Domain\Education\StudentGroup\Event;

use Domain\Date;
use Domain\DomainEvent;
use Domain\Contract\IdentifiesAggregate;
use Domain\Education\StudentGroup\PricePerHour;
use Domain\Education\StudentGroup\Schedule;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\Education\StudentGroup\StudentGroupName;

class StudentGroupWasCreated extends DomainEvent
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
     * @var PricePerHour
     */
    private $pricePerHour;

    /**
     * @var Date
     */
    private $createdDate;

    /**
     * @var Schedule
     */
    private $schedule;

    /**
     * StudentGroupWasInitiated constructor.
     * @param StudentGroupId $studentGroupId
     * @param Schedule $schedule
     * @param StudentGroupName $name
     * @param PricePerHour $pricePerHour
     * @param Date $createdDate
     */
    public function __construct(
        StudentGroupId $studentGroupId,
        Schedule $schedule,
        StudentGroupName $name,
        PricePerHour $pricePerHour,
        Date $createdDate
    ) {
        $this->studentGroupId = $studentGroupId;
        $this->schedule = $schedule;
        $this->name = $name;
        $this->pricePerHour = $pricePerHour;
        $this->createdDate = $createdDate;
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
    public function schedule(): Schedule
    {
        return $this->schedule;
    }

    /**
     * @return StudentGroupName
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return PricePerHour
     */
    public function pricePerHour()
    {
        return $this->pricePerHour;
    }

    /**
     * @return Date
     */
    public function createdDate()
    {
        return $this->createdDate;
    }

    /**
     * @return mixed
     */
    public function data(): array
    {
        return [
            'name' => (string)$this->name,
            'schedule' => (string)$this->schedule,
            'price_per_hour' => (string)$this->pricePerHour,
            'created_on' => (string)$this->createdDate,
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
            Schedule::fromString($data->schedule),
            new StudentGroupName($data->name),
            new PricePerHour($data->price_per_hour),
            Date::fromString($data->created_on)
        );
    }
}
