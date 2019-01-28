<?php

namespace Domain\Finance\Student\Command;

class PayOffDebtsCommand
{
    /**
     * @var string
     */
    private $studentId;

    /**
     * @param string $studentId
     */
    public function __construct(string $studentId)
    {
        $this->studentId = $studentId;
    }

    /**
     * @return string
     */
    public function studentId(): string
    {
        return $this->studentId;
    }
}
