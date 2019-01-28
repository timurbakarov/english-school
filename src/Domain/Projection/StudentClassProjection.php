<?php

namespace Domain\Projection;

use Domain\BaseProjection;
use App\Repository\StudentClassReadModel;
use Domain\Finance\Student\Event\StudentPaidOffDebt;
use Domain\Education\Lesson\Event\StudentMissedLesson;
use Domain\Finance\Student\Event\StudentPaidForLesson;
use Domain\Education\Lesson\Event\StudentAttendedLesson;
use Domain\Finance\Student\Event\StudentGotDebtForLesson;
use Domain\Education\Lesson\Event\StudentMissedLessonWasUnmarked;

class StudentClassProjection extends BaseProjection
{
    /**
     * @var StudentClassReadModel
     */
    private $studentClassReadModel;

    /**
     * StudentClassProjection constructor.
     * @param StudentClassReadModel $studentClassReadModel
     */
    public function __construct(StudentClassReadModel $studentClassReadModel)
    {
        $this->studentClassReadModel = $studentClassReadModel;
    }

    /**
     * @return array
     */
    public function events(): array
    {
        return [
            StudentAttendedLesson::class,
            StudentMissedLesson::class,
            StudentMissedLessonWasUnmarked::class,
            StudentPaidForLesson::class,
            StudentGotDebtForLesson::class,
            StudentPaidOffDebt::class,
        ];
    }

    public function whenStudentAttendedLesson(StudentAttendedLesson $event)
    {
        $studentClass = $this->studentClassReadModel->newInstance();

        $studentClass->study_class_id = (string)$event->getAggregateId();
        $studentClass->student_id = (string)$event->studentId();
        $studentClass->status = 'attended';

        $studentClass->saveOrFail();
    }

    public function whenStudentMissedLesson(StudentMissedLesson $event)
    {
        $studentClass = $this->studentClassReadModel->newInstance();

        $studentClass->study_class_id = (string)$event->getAggregateId();
        $studentClass->student_id = (string)$event->studentId();
        $studentClass->status = 'missed';

        $studentClass->saveOrFail();
    }

    public function whenStudentMissedLessonWasUnmarked(StudentMissedLessonWasUnmarked $event)
    {
        $this->studentClassReadModel
            ->where('study_class_id', (string)$event->getAggregateId())
            ->where('student_id', (string)$event->studentId())
            ->delete();
    }

    public function whenStudentPaidForLesson(StudentPaidForLesson $event)
    {
        $lesson = $this->studentClassReadModel
            ->where('student_id', (string)$event->getAggregateId())
            ->where('study_class_id', (string)$event->lessonId())
            ->firstOrFail();

        $lesson->is_payed = 1;
        $lesson->payment = $event->amount()->value();

        $lesson->saveOrFail();
    }

    public function whenStudentGotDebtForLesson(StudentGotDebtForLesson $event)
    {
        $lesson = $this->studentClassReadModel
            ->where('student_id', (string)$event->getAggregateId())
            ->where('study_class_id', (string)$event->lessonId())
            ->firstOrFail();

        $lesson->is_payed = 0;
        $lesson->payment = $event->amount()->value();

        $lesson->saveOrFail();
    }

    public function whenStudentPaidOffDebt(StudentPaidOffDebt $event)
    {
        $lesson = $this->studentClassReadModel
            ->where('student_id', (string)$event->getAggregateId())
            ->where('study_class_id', (string)$event->lessonId())
            ->firstOrFail();

        $lesson->is_payed = 1;

        $lesson->saveOrFail();
    }

    /**
     * @return mixed
     */
    public function readModel()
    {
        return $this->studentClassReadModel;
    }
}
