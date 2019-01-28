<?php

namespace Domain\StudyClass;

use Domain\Exception\InvalidArgumentException;
use Domain\StudentId;

class StudentClass
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
     * StudentClass constructor.
     * @param StudentId $studentId
     * @param string $status
     * @throws InvalidArgumentException
     */
    public function __construct(StudentId $studentId, string $status)
    {
        if(!in_array($status, ['visited', 'missed'])) {
            throw new InvalidArgumentException("Status is invalid");
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
