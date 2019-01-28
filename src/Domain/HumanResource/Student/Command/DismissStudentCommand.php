<?php

namespace Domain\HumanResource\Student\Command;

class DismissStudentCommand
{
    /**
     * @var string
     */
    private $studentId;

    /**
     * @var string
     */
    private $dismissedOn;

    /**
     * @var string
     */
    private $reason;

    /**
     * @param string $studentId
     * @param string $dismissedOn
     * @param string|NULL $reason
     */
    public function __construct(string $studentId, string $dismissedOn, string $reason = null)
    {
        $this->studentId = $studentId;
        $this->dismissedOn = $dismissedOn;
        $this->reason = $reason ?? '';
    }

    /**
     * @return string
     */
    public function studentId(): string
    {
        return $this->studentId;
    }

    /**
     * @return string
     */
    public function dismissedOn(): string
    {
        return $this->dismissedOn;
    }

    /**
     * @return string
     */
    public function reason(): string
    {
        return $this->reason;
    }
}
