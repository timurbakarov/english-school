<?php

namespace Domain\Education\StudentGroup\Specification;

use Domain\Education\StudentGroup\StudentGroupId;
use Domain\Education\StudentGroup\StudentGroupSearcher;

class StudentGroupExistsSpec
{
    /**
     * @var StudentGroupSearcher
     */
    private $studentGroupSearcher;

    /**
     * @param StudentGroupSearcher $studentGroupSearcher
     */
    public function __construct(StudentGroupSearcher $studentGroupSearcher)
    {
        $this->studentGroupSearcher = $studentGroupSearcher;
    }

    /**
     * @param StudentGroupId $studentGroupId
     * @return bool
     */
    public function isSpecifiedBy(StudentGroupId $studentGroupId) : bool
    {
        return $this->studentGroupSearcher->exists($studentGroupId);
    }
}
