<?php

namespace Infr\StudentGroup;

use App\Repository\StudentsGroupReadModel;
use Domain\Education\StudentGroup\StudentGroupId;

class StudentGroupSearcher implements \Domain\Education\StudentGroup\StudentGroupSearcher
{
    /**
     * @var StudentsGroupReadModel
     */
    private $studentsGroupReadModel;

    /**
     * @param StudentsGroupReadModel $studentsGroupReadModel
     */
    public function __construct(StudentsGroupReadModel $studentsGroupReadModel)
    {
        $this->studentsGroupReadModel = $studentsGroupReadModel;
    }

    /**
     * @param StudentGroupId $studentGroupId
     * @return bool
     */
    public function exists(StudentGroupId $studentGroupId): bool
    {
        return $this->studentsGroupReadModel->where('id', (string)$studentGroupId)->count() > 0;
    }

    /**
     * @param StudentGroupId $studentGroupId
     * @return bool
     */
    public function isActive(StudentGroupId $studentGroupId): bool
    {
        $studentGroup = $this->studentsGroupReadModel->findOrFail((string)$studentGroupId);

        return $studentGroup->is_active;
    }
}
