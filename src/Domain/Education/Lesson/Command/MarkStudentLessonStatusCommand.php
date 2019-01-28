<?php

namespace Domain\Education\Lesson\Command;

class MarkStudentLessonStatusCommand
{
    /**
     * @var string
     */
    private $lessonId;

    /**
     * @var string
     */
    private $studentId;

    /**
     * @var string
     */
    private $status;

    /**
     * @param string $lessonId
     * @param string $studentId
     * @param string $status
     */
    public function __construct(string $lessonId, string $studentId, string $status)
    {
        $this->lessonId = $lessonId;
        $this->studentId = $studentId;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function lessonId(): string
    {
        return $this->lessonId;
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
    public function status(): string
    {
        return $this->status;
    }
}
