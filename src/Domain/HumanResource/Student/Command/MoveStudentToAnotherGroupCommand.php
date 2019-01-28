<?php

namespace Domain\HumanResource\Student\Command;

class MoveStudentToAnotherGroupCommand
{
    /**
     * @var string
     */
    private $studentId;

    /**
     * @var string
     */
    private $groupId;

    /**
     * @var string
     */
    private $movedDate;

    /**
     * @param string $studentId
     * @param string $groupId
     * @param string $movedDate
     */
    public function __construct(string $studentId, string $groupId, string $movedDate = null)
    {
        $this->studentId = $studentId;
        $this->groupId = $groupId;
        $this->movedDate = $movedDate;
    }

    /**
     * @return string
     */
    public function groupId(): string
    {
        return $this->groupId;
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
    public function movedDate(): string
    {
        return $this->movedDate;
    }
}
