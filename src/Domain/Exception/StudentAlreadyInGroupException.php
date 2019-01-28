<?php

namespace Domain\Exception;

use Domain\StudentId;

class StudentAlreadyInGroupException extends \Exception
{
    public static function create(StudentId $studentId)
    {
        $studentId = (string)$studentId;

        return new self("Student [$studentId] already in group");
    }
}
