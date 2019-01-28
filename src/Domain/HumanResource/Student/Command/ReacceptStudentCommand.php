<?php

namespace Domain\HumanResource\Student\Command;

class ReacceptStudentCommand
{
    /**
     * @var string
     */
    private $studentId;

    /**
     * @var string
     */
    private $studentGroupId;

    /**
     * @var string
     */
    private $reacceptOn;

    /**
     * @param string $studentId
     * @param string $studentGroupId
     * @param string $reacceptOn
     */
    public function __construct(string $studentId, string $studentGroupId, string $reacceptOn)
    {
        $this->studentId = $studentId;
        $this->studentGroupId = $studentGroupId;
        $this->reacceptOn = $reacceptOn;
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
    public function studentGroupId(): string
    {
        return $this->studentGroupId;
    }

    /**
     * @return string
     */
    public function reacceptOn(): string
    {
        return $this->reacceptOn;
    }
}
