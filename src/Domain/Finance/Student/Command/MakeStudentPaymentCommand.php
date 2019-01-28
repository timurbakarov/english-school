<?php

namespace Domain\Finance\Student\Command;

class MakeStudentPaymentCommand
{
    /**
     * @var string
     */
    private $studentId;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $payedOn;

    /**
     * @param string $studentId
     * @param int $amount
     * @param string $type
     * @param string $payedOn
     */
    public function __construct(string $studentId, int $amount, string $type, string $payedOn)
    {
        $this->studentId = $studentId;
        $this->amount = $amount;
        $this->type = $type;
        $this->payedOn = $payedOn;
    }

    /**
     * @return string
     */
    public function studentId(): string
    {
        return $this->studentId;
    }

    /**
     * @return int
     */
    public function amount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function payedOn(): string
    {
        return $this->payedOn;
    }
}
