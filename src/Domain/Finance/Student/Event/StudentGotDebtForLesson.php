<?php

namespace Domain\Finance\Student\Event;

use Domain\Date;
use Domain\LessonId;
use Domain\StudentId;
use Domain\DomainEvent;
use Domain\Contract\IdentifiesAggregate;
use Domain\Finance\Student\PaymentAmount;

class StudentGotDebtForLesson extends DomainEvent
{
    /**
     * @var StudentId
     */
    private $studentId;

    /**
     * @var LessonId
     */
    private $lessonId;

    /**
     * @var PaymentAmount
     */
    private $amount;

    /**
     * @var Date
     */
    private $gotDebtOn;

    /**
     * @param StudentId $studentId
     * @param LessonId $lessonId
     * @param PaymentAmount $amount
     * @param Date $gotDebtOn
     */
    public function __construct(StudentId $studentId, LessonId $lessonId, PaymentAmount $amount, Date $gotDebtOn)
    {
        $this->studentId = $studentId;
        $this->lessonId = $lessonId;
        $this->amount = $amount;
        $this->gotDebtOn = $gotDebtOn;
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
     * @return LessonId
     */
    public function lessonId(): LessonId
    {
        return $this->lessonId;
    }

    /**
     * @return PaymentAmount
     */
    public function amount(): PaymentAmount
    {
        return $this->amount;
    }

    /**
     * @return Date
     */
    public function gotDebtOn(): Date
    {
        return $this->gotDebtOn;
    }

    /**
     * @return mixed
     */
    public function data(): array
    {
        return [
            'lesson_id' => (string)$this->lessonId,
            'amount' => (string)$this->amount,
            'got_debt_on' => (string)$this->gotDebtOn,
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
            StudentId::fromString($data->aggregate_id),
            LessonId::fromString($data->lesson_id),
            new PaymentAmount($data->amount),
            Date::fromString($data->got_debt_on)
        );
    }
}
