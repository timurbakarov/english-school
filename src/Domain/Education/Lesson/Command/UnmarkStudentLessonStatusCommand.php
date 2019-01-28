<?php

namespace Domain\Education\Lesson\Command;

class UnmarkStudentLessonStatusCommand
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
     * @param string $lessonId
     * @param string $studentId     *
     */
    public function __construct(string $lessonId, string $studentId)
    {
        $this->lessonId = $lessonId;
        $this->studentId = $studentId;
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
}
