<?php

namespace Domain\Finance\Student\Command;

class PayBillForLessonCommand
{
    /**
     * @var string
     */
    private $studentId;

    /**
     * @var string
     */
    private $lessonId;

    /**
     * @param string $studentId
     * @param string $lessonId
     */
    public function __construct(string $studentId, string $lessonId)
    {
        $this->studentId = $studentId;
        $this->lessonId = $lessonId;
    }

    /**
     * @return string
     */
    public function studentId(): string
    {
        return $this->studentId;
    }

    /**
     * @return string
     */
    public function lessonId(): string
    {
        return $this->lessonId;
    }
}
