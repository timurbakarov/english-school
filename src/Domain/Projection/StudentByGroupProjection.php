<?php

namespace Domain\Projection;

use Domain\BaseProjection;
use App\Repository\StudyClassReadModel;
use App\Repository\StudentByGroupAndDateReadModel;
use Domain\Education\Lesson\Event\StudentMissedLesson;
use Domain\Education\Lesson\Event\StudentAttendedLesson;
use Domain\Education\Lesson\Event\StudentMissedLessonWasUnmarked;

class StudentByGroupProjection extends BaseProjection
{
    /**
     * @var StudentByGroupAndDateReadModel
     */
    private $studentByGroupAndDateReadModel;
    /**
     * @var StudyClassReadModel
     */
    private $studyClassReadModel;

    /**
     * @param StudentByGroupAndDateReadModel $studentByGroupAndDateReadModel
     * @param StudyClassReadModel $studyClassReadModel
     */
    public function __construct(
        StudentByGroupAndDateReadModel $studentByGroupAndDateReadModel,
        StudyClassReadModel $studyClassReadModel
    ) {
        $this->studentByGroupAndDateReadModel = $studentByGroupAndDateReadModel;
        $this->studyClassReadModel = $studyClassReadModel;
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
        ];
    }

    public function whenStudentAttendedLesson(StudentAttendedLesson $event)
    {
        $this->add((string)$event->getAggregateId(), (string)$event->studentId());
    }

    public function whenStudentMissedLesson(StudentMissedLesson $event)
    {
        $this->add((string)$event->getAggregateId(), (string)$event->studentId());
    }

    public function whenStudentMissedLessonWasUnmarked(StudentMissedLessonWasUnmarked $event)
    {
        $this->remove((string)$event->getAggregateId(), (string)$event->studentId());
    }

    private function remove($lessonId, $studentId)
    {
//        $lesson = $this->studyClassReadModel->findOrFail($lessonId);
//
//        $groupId = $lesson->group_id;
//        $lessonDate = new \DateTime($lesson->date);
//        $year = $lessonDate->format('Y');
//        $month = (int)$lessonDate->format('m');
//
//        $this->studentByGroupAndDateReadModel
//            ->where('student_id', $studentId)
//            ->where('group_id', $groupId)
//            ->where('year', $year)
//            ->where('month', $month)
//            ->delete();
    }

    private function add($lessonId, $studentId)
    {
        $lesson = $this->studyClassReadModel->findOrFail($lessonId);

        $groupId = $lesson->group_id;
        $lessonDate = new \DateTime($lesson->date);
        $year = $lessonDate->format('Y');
        $month = (int)$lessonDate->format('m');

        $exists = $this->studentByGroupAndDateReadModel
            ->where('student_id', $studentId)
            ->where('group_id', $groupId)
            ->where('year', $year)
            ->where('month', $month)
            ->count() > 0;

        if($exists) {
            return;
        }

        $record = $this->studentByGroupAndDateReadModel->newInstance();

        $record->group_id = $groupId;
        $record->student_id = $studentId;
        $record->year = $year;
        $record->month = $month;

        $record->saveOrFail();
    }

    /**
     * @return mixed
     */
    public function readModel()
    {
        return $this->studentByGroupAndDateReadModel;
    }
}
