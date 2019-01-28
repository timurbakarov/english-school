<?php

namespace Domain\Exception;

use Domain\StudentId;

class StudentIsNotActiveAndCanNotBeRemoved extends \Exception
{
    public static function create(StudentId $studentId)
    {
        return new self("Student is not active and can not be removed");
    }
}
