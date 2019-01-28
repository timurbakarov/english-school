<?php

namespace Domain\Education\Lesson\Event;

use Domain\LessonId;
use Domain\StudentId;
use Domain\DomainEvent;
use Domain\Contract\IdentifiesAggregate;

class StudentAttendedLesson extends DomainEvent
{
    /**
     * @var LessonId
     */
    private $lessonId;

    /**
     * @var StudentId
     */
    private $studentId;

    /**
     * @param LessonId $lessonId
     * @param StudentId $studentId
     */
    public function __construct(LessonId $lessonId, StudentId $studentId)
    {
        $this->lessonId = $lessonId;
        $this->studentId = $studentId;
    }


    /**
     * The Aggregate this event belongs to.
     * @return IdentifiesAggregate
     */
    public function getAggregateId()
    {
        return $this->lessonId;
    }

    /**
     * @return StudentId
     */
    public function studentId()
    {
        return $this->studentId;
    }

    /**
     * @return mixed
     */
    public function data(): array
    {
        return [
            'student_id' => (string)$this->studentId,
        ];
    }

    /**
     * @param $data
     * @return \Domain\Contract\DomainEvent
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public static function rebuildFromData($data): \Domain\Contract\DomainEvent
    {
        return new self(
            LessonId::fromString($data->aggregate_id),
            StudentId::fromString($data->student_id)
        );
    }
}
