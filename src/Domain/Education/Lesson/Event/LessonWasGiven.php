<?php

namespace Domain\Education\Lesson\Event;

use Domain\Time;
use Domain\Date;
use Domain\LessonId;
use Domain\DomainEvent;
use Domain\Contract\IdentifiesAggregate;
use Domain\Education\StudentGroup\PricePerHour;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\Education\StudentGroup\Schedule\GroupClassDuration;

class LessonWasGiven extends DomainEvent
{
    /**
     * @var LessonId
     */
    private $lessonId;

    /**
     * @var StudentGroupId
     */
    private $studentGroupId;

    /**
     * @var Date
     */
    private $date;

    /**
     * @var Time
     */
    private $time;

    /**
     * @var PricePerHour
     */
    private $pricePerHour;

    /**
     * @var GroupClassDuration
     */
    private $duration;

    /**
     * @param LessonId $lessonId
     * @param StudentGroupId $studentGroupId
     * @param Date $date
     * @param Time $time
     * @param PricePerHour $pricePerHour
     * @param GroupClassDuration $duration
     */
    public function __construct(
        LessonId $lessonId,
        StudentGroupId $studentGroupId,
        Date $date,
        Time $time,
        PricePerHour $pricePerHour,
        GroupClassDuration $duration
    ) {
        $this->lessonId = $lessonId;
        $this->studentGroupId = $studentGroupId;
        $this->date = $date;
        $this->time = $time;
        $this->pricePerHour = $pricePerHour;
        $this->duration = $duration;
    }

    /**
     * The Aggregate this event belongs to.
     * @return IdentifiesAggregate
     */
    public function getAggregateId()
    {
        return $this->lessonId;
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
    public function date(): Date
    {
        return $this->date;
    }

    /**
     * @return Time
     */
    public function time(): Time
    {
        return $this->time;
    }

    /**
     * @return PricePerHour
     */
    public function pricePerHour(): PricePerHour
    {
        return $this->pricePerHour;
    }

    /**
     * @return GroupClassDuration
     */
    public function duration(): GroupClassDuration
    {
        return $this->duration;
    }

    /**
     * @return mixed
     */
    public function data(): array
    {
        return [
            'group_id' => (string)$this->studentGroupId,
            'date' => (string)$this->date,
            'time' => (string)$this->time,
            'price_per_hour' => (string)$this->pricePerHour,
            'duration' => (string)$this->duration,
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
            LessonId::fromString($data->aggregate_id),
            StudentGroupId::fromString($data->group_id),
            Date::fromString($data->date),
            Time::fromString($data->time),
            new PricePerHour($data->price_per_hour),
            new GroupClassDuration($data->duration)
        );
    }

    /**
     * @param LessonId|NULL $lessonId
     * @return \Domain\Contract\DomainEvent
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public static function forTest(LessonId $lessonId = null)
    {
        $data = new \stdClass();
        $data->aggregate_id = $lessonId ?: LessonId::generate();
        $data->group_id = StudentGroupId::generate();
        $data->date = '2018-10-12';
        $data->time = '10:30';
        $data->price_per_hour = 300;
        $data->duration = 1;

        return self::rebuildFromData($data);
    }
}
