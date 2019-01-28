<?php

namespace Domain\Finance\Student\Event;

use Domain\Contract\IdentifiesAggregate;
use Domain\Date;
use Domain\DomainEvent;
use Domain\StudentId;
use Domain\Finance\Student\PaymentAmount;
use Domain\Finance\Student\PaymentId;
use Domain\Finance\Student\PaymentType;

class StudentMadePayment extends DomainEvent
{
    /**
     * @var StudentId
     */
    private $studentId;

    /**
     * @var PaymentId
     */
    private $paymentId;

    /**
     * @var PaymentAmount
     */
    private $amount;

    /**
     * @var PaymentType
     */
    private $type;

    /**
     * @var Date
     */
    private $payedOn;

    /**
     * @param StudentId $studentId
     * @param PaymentId $paymentId
     * @param PaymentAmount $amount
     * @param PaymentType $type
     * @param Date $payedOn
     */
    public function __construct(StudentId $studentId, PaymentId $paymentId, PaymentAmount $amount, PaymentType $type, Date $payedOn)
    {
        $this->studentId = $studentId;
        $this->paymentId = $paymentId;
        $this->amount = $amount;
        $this->type = $type;
        $this->payedOn = $payedOn;
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
     * @return PaymentId
     */
    public function paymentId(): PaymentId
    {
        return $this->paymentId;
    }

    /**
     * @return PaymentAmount
     */
    public function amount(): PaymentAmount
    {
        return $this->amount;
    }

    /**
     * @return PaymentType
     */
    public function type(): PaymentType
    {
        return $this->type;
    }

    /**
     * @return Date
     */
    public function payedOn(): Date
    {
        return $this->payedOn;
    }

    /**
     * @return mixed
     */
    public function data(): array
    {
        return [
            'payment_id' => (string)$this->paymentId,
            'amount' => (string)$this->amount,
            'type' => (string)$this->type,
            'payed_on' => (string)$this->payedOn,
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
            PaymentId::fromString($data->payment_id),
            new PaymentAmount($data->amount),
            PaymentType::fromString($data->type),
            Date::fromString($data->payed_on)
        );
    }
}
