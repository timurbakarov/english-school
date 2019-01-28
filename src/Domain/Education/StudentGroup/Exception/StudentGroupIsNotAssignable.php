<?php

namespace Domain\Education\StudentGroup\Exception;

use Domain\Exception;
use Domain\Education\StudentGroup\StudentGroupId;

class StudentGroupIsNotAssignable extends Exception
{
    /**
     * @param StudentGroupId $studentGroupId
     * @return StudentGroupIsNotAssignable
     */
    public static function create(StudentGroupId $studentGroupId)
    {
        $message = sprintf('Student group with id [%s] is not assignable', (string)$studentGroupId);

        return new self($message);
    }
}
