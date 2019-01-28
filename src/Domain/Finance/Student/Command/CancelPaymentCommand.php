<?php

namespace Domain\Finance\Student\Command;

class CancelPaymentCommand
{
    /**
     * @var string
     */
    private $studentId;

    /**
     * @var string
     */
    private $paymentId;

    /**
     * @var string
     */
    private $comment;

    /**
     * @param string $studentId
     * @param string $paymentId
     * @param string $comment
     */
    public function __construct(string $studentId, string $paymentId, string $comment = null)
    {
        $this->studentId = $studentId;
        $this->paymentId = $paymentId;
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function studentId()
    {
        return $this->studentId;
    }

    /**
     * @return string
     */
    public function paymentId()
    {
        return $this->paymentId;
    }

    /**
     * @return string
     */
    public function comment()
    {
        return $this->comment;
    }
}
