<?php

namespace Domain\HumanResource\Student\Exception;

use Domain\Exception;
use Domain\StudentId;

class StudentIsDismissedException extends Exception
{
    /**
     * @param StudentId $studentId
     * @return StudentIsDismissedException
     */
    public static function create(StudentId $studentId)
    {
        $message = sprintf('Student [%s] is dismissed', (string)$studentId);

        return new self($message);
    }
}
