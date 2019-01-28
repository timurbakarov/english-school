<?php

namespace Domain\Education\StudentGroup\Command;

class ChangeStudentGroupScheduleCommand
{
    /**
     * @var string
     */
    private $studentGroupId;

    /**
     * @var string
     */
    private $schedule;

    /**
     * @param string $studentGroupId
     * @param string $schedule
     */
    public function __construct(string $studentGroupId, string $schedule)
    {
        $this->studentGroupId = $studentGroupId;
        $this->schedule = $schedule;
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
    public function schedule(): string
    {
        return $this->schedule;
    }
}
