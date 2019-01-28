<?php

namespace Domain\Exception;

use Domain\StudentId;

class StudentCanNotBeLeaveHisBalanceIsNotZero extends \Exception
{
    public static function create(StudentId $studentId)
    {
        return new self("Student can not leave. Balance is not zero");
    }
}
