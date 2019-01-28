<?php

namespace Domain\Education\StudentGroup\Event;

use Domain\Date;
use Domain\DomainEvent;
use Domain\Contract\IdentifiesAggregate;
use Domain\Education\StudentGroup\PricePerHour;
use Domain\Education\StudentGroup\StudentGroupId;

class StudentGroupPricePerHourWasChanged extends DomainEvent
{
    /**
     * @var StudentGroupId
     */
    private $studentGroupId;

    /**
     * @var PricePerHour
     */
    private $pricePerHour;

    /**
     * @var Date
     */
    private $changedOn;

    /**
     * StudentGroupPricePerHourWasChanged constructor.
     * @param StudentGroupId $studentGroupId
     * @param PricePerHour $pricePerHour
     * @param Date $changedOn
     */
    public function __construct(StudentGroupId $studentGroupId, PricePerHour $pricePerHour, Date $changedOn)
    {
        $this->studentGroupId = $studentGroupId;
        $this->pricePerHour = $pricePerHour;
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
     * @return PricePerHour
     */
    public function pricePerHour()
    {
        return $this->pricePerHour;
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
            'price_per_hour' => (string)$this->pricePerHour,
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
            new PricePerHour($data->price_per_hour),
            Date::fromString($data->changed_on)
        );
    }
}
