<?php

namespace Domain\StudyClass;

class StudyStudents
{
    /**
     * @var array
     */
    private $studentsClassStatus;

    /**
     * StudyStudents constructor.
     * @param StudentClassStatus[] ...$studentsClassStatus
     */
    public function __construct(StudentClassStatus ...$studentsClassStatus)
    {
        $this->studentsClassStatus = $studentsClassStatus;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->studentsClassStatus);
    }

    /**
     * @param string $status
     * @return array
     */
    public function countByStatus(string $status)
    {
        return count(array_filter($this->studentsClassStatus, function(StudentClassStatus $studentClassStatus) use($status) {
            return $studentClassStatus->status() == $status;
        }));
    }

    /**
     * @return StudentClassStatus[]
     */
    public function value()
    {
        return $this->studentsClassStatus;
    }
}
