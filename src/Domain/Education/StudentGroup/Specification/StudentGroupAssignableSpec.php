<?php

namespace Domain\Education\StudentGroup\Specification;

use Domain\Education\StudentGroup\StudentGroupId;

class StudentGroupAssignableSpec
{
    /**
     * @var StudentGroupActiveSpec
     */
    private $studentGroupActiveSpec;

    /**
     * @var StudentGroupExistsSpec
     */
    private $studentGroupExistsSpec;

    /**
     * @param StudentGroupActiveSpec $studentGroupActiveSpec
     * @param StudentGroupExistsSpec $studentGroupExistsSpec
     */
    public function __construct(StudentGroupActiveSpec $studentGroupActiveSpec, StudentGroupExistsSpec $studentGroupExistsSpec)
    {
        $this->studentGroupActiveSpec = $studentGroupActiveSpec;
        $this->studentGroupExistsSpec = $studentGroupExistsSpec;
    }

    /**
     * @param StudentGroupId $studentGroupId
     * @return bool
     */
    public function isSpecifiedBy(StudentGroupId $studentGroupId)
    {
        return $this->studentGroupExistsSpec->isSpecifiedBy($studentGroupId)
            && $this->studentGroupActiveSpec->isSpecifiedBy($studentGroupId);
    }
}
