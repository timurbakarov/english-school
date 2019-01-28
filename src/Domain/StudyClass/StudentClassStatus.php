<?php

namespace Domain\StudyClass;

use Domain\StudentId;
use Domain\Exception\InvalidArgumentException;

class StudentClassStatus
{
    /**
     * @var StudentId
     */
    private $studentId;

    /**
     * @var string
     */
    private $status;

    /**
     * StudentClassStatus constructor.
     * @param StudentId $studentId
     * @param string $status
     * @throws InvalidArgumentException
     */
    public function __construct(StudentId $studentId, string $status)
    {
        if(!in_array($status, ['visited', 'missed'])) {
            throw new InvalidArgumentException("Invalid status");
        }

        $this->studentId = $studentId;
        $this->status = $status;
    }

    /**
     * @return StudentId
     */
    public function studentId()
    {
        return $this->studentId;
    }

    /**
     * @return string
     */
    public function status()
    {
        return $this->status;
    }
}
