<?php

namespace Domain\Education\StudentGroup;

interface StudentGroupSearcher
{
    /**
     * @param StudentGroupId $studentGroupId
     * @return bool
     */
    public function exists(StudentGroupId $studentGroupId) : bool;

    /**
     * @param StudentGroupId $studentGroupId
     * @return bool
     */
    public function isActive(StudentGroupId $studentGroupId) : bool;
}
