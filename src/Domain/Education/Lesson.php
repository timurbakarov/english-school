<?php

namespace Domain\Education;

use Domain\Date;
use Domain\Education\Lesson\Event\StudentAttendedLessonWasUnmarked;
use Domain\Education\Lesson\Event\StudentMissedLessonWasUnmarked;
use Domain\Education\Lesson\Exception\StudentWasAlreadyMarkedException;
use Domain\HumanResource\Student;
use Domain\Time;
use Domain\LessonId;
use Domain\StudentId;
use Domain\AggregateRoot;
use Domain\Contract\RecordsEvents;
use Domain\Contract\IsEventSourced;
use Domain\Exception\InvalidArgumentException;
use Domain\Education\StudentGroup\PricePerHour;
use Domain\Education\Lesson\Event\LessonWasGiven;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\Education\Lesson\Event\StudentMissedLesson;
use Domain\Education\Lesson\Event\StudentAttendedLesson;
use Domain\Education\StudentGroup\Schedule\GroupClassDuration;

class Lesson implements IsEventSourced, RecordsEvents
{
    use AggregateRoot;

    /**
     * @var LessonId
     */
    private $id;

    /**
     * @var Date
     */
    private $date;

    /**
     * @var bool
     */
    private $given = false;

    /**
     * @var PricePerHour
     */
    private $pricePerHour;

    /**
     * @var GroupClassDuration
     */
    private $duration;

    /**
     * @var array
     */
    private $students = [];

    /**
     * @param LessonId $id
     */
    private function __construct(LessonId $id)
    {
        $this->id = $id;
    }

    /**
     * @param LessonId $id
     * @param StudentGroupId $studentGroupId
     * @param Date $date
     * @param Time $time
     * @param PricePerHour $pricePerHour
     * @param GroupClassDuration $duration
     * @return Lesson
     */
    public static function give(
        LessonId $id,
        StudentGroupId $studentGroupId,
        Date $date,
        Time $time,
        PricePerHour $pricePerHour,
        GroupClassDuration $duration
    ) {
        $lesson = new self($id);

        $lesson->recordThat(new LessonWasGiven(
            $id,
            $studentGroupId,
            $date,
            $time,
            $pricePerHour,
            $duration
        ));

        return $lesson;
    }

    private function whenLessonWasGiven(LessonWasGiven $event)
    {
        $this->given = true;
        $this->pricePerHour = $event->pricePerHour();
        $this->duration = $event->duration();
        $this->date = $event->date();
    }

    /**
     * @param Student $student
     * @param string $status
     * @return $this
     * @throws InvalidArgumentException
     * @throws StudentWasAlreadyMarkedException
     * @throws Student\Exception\StudentIsDismissedException
     */
    public function markStudentLessonStatus(Student $student, string $status)
    {
        if(!in_array($status, ['attended', 'missed'])) {
            throw new InvalidArgumentException('Status is invalid');
        }

        if($this->hasStudent($student->id())) {
            throw new StudentWasAlreadyMarkedException('Student was already marked');
        }

        if($student->isDismissed()) {
            throw new Student\Exception\StudentIsDismissedException('Can not mark student because he is dismissed');
        }

        if($status == 'attended') {
            $this->recordThat(new StudentAttendedLesson($this->id, $student->id()));
        } else {
            $this->recordThat(new StudentMissedLesson($this->id, $student->id()));
        }

        return $this;
    }

    private function whenStudentAttendedLesson(StudentAttendedLesson $event)
    {
        $this->students[(string)$event->studentId()] = [
            'status' => 'attended',
        ];
    }

    private function whenStudentMissedLesson(StudentMissedLesson $event)
    {
        $this->students[(string)$event->studentId()] = [
            'status' => 'missed',
        ];
    }

    /**
     * @param StudentId $studentId
     * @return $this
     * @throws InvalidArgumentException
     */
    public function unmarkStudentLessonStatus(StudentId $studentId)
    {
        if(!$this->hasStudent($studentId)) {
            throw new InvalidArgumentException('Student does not exist in this lesson');
        }

        $studentLesson = $this->students[(string)$studentId];

        if($studentLesson['status'] == 'missed') {
            $this->recordThat(new StudentMissedLessonWasUnmarked($this->id, $studentId));
        } else {
            $this->recordThat(new StudentAttendedLessonWasUnmarked($this->id, $studentId));
        }

        return $this;
    }

    private function whenStudentMissedLessonWasUnmarked(StudentMissedLessonWasUnmarked $event)
    {
        unset($this->students[(string)$event->studentId()]);
    }

    private function whenStudentAttendedLessonWasUnmarked(StudentAttendedLessonWasUnmarked $event)
    {
        unset($this->students[(string)$event->studentId()]);
    }

    /**
     * @param StudentId $studentId
     * @return bool
     */
    private function hasStudent(StudentId $studentId)
    {
        return array_key_exists((string)$studentId, $this->students);
    }

    /**
     * @return LessonId
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return float|int
     */
    public function price()
    {
        return $this->pricePerHour->value() * $this->duration->value();
    }

    /**
     * @return Date
     */
    public function date()
    {
        return $this->date;
    }

    /**
     * @return bool
     */
    public function wasGiven() : bool
    {
        return $this->given;
    }
}
