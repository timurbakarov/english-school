<?php

namespace Domain\Finance\Student\Event;

use Domain\Date;
use Domain\StudentId;
use Domain\DomainEvent;
use Domain\Finance\Student\PaymentId;
use Domain\Contract\IdentifiesAggregate;
use Domain\Finance\Student\PaymentAmount;

class PaymentWasCancelled extends DomainEvent
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
     * @var string
     */
    private $comment;

    /**
     * @var Date
     */
    private $cancelledOn;

    /**
     * @var Date
     */
    private $payedOn;

    /**
     * @param StudentId $studentId
     * @param PaymentId $paymentId
     * @param PaymentAmount $amount
     * @param string $comment
     * @param Date $cancelledOn
     * @param Date $payedOn
     */
    public function __construct(
        StudentId $studentId,
        PaymentId $paymentId,
        PaymentAmount $amount,
        string $comment,
        Date $cancelledOn,
        Date $payedOn
    ) {
        $this->studentId = $studentId;
        $this->paymentId = $paymentId;
        $this->amount = $amount;
        $this->comment = $comment;
        $this->cancelledOn = $cancelledOn;
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
    public function amount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function comment(): string
    {
        return $this->comment;
    }

    /**
     * @return Date
     */
    public function cancelledOn(): Date
    {
        return $this->cancelledOn;
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
            'comment' => $this->comment,
            'cancelled_on' => (string)$this->cancelledOn,
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
            $data->comment,
            Date::fromString($data->cancelled_on),
            Date::fromString($data->payed_on)
        );
    }
}
