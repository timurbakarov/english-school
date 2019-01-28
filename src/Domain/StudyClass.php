<?php

namespace Domain;

use Domain\Contract\IsEventSourced;
use Domain\Contract\RecordsEvents;
use Domain\Event\StudentWasAddedToStudyClass;
use Domain\Event\StudyClassWasGiven;
use Domain\Exception\StudentWasAlreadyAddedToStudyClass;
use Domain\StudyClass\StudentClassStatus;
use Domain\Schedule\GroupClassDuration;
use Domain\StudentGroup\PricePerHour;
use Domain\StudentGroup\StudentGroupId;
use Domain\StudyClass\StudyClassId;
use Domain\StudyClass\StudyStudents;

class StudyClass implements RecordsEvents, IsEventSourced
{
    use RecordEventsTrait;
    use EventSourcedTrait;

    /**
     * @var StudyClassId
     */
    private $id;

    /**
     * @var StudentGroupId
     */
    private $studentGroup;

    /**
     * @var StudentClassStatus[]
     */
    private $studyStudents;

    /**
     * @var Date
     */
    private $date;

    /**
     * @var Time
     */
    private $time;

    /**
     * @var PricePerHour
     */
    private $pricePerHour;

    /**
     * @var GroupClassDuration
     */
    private $duration;

    /**
     * StudyClass constructor.
     * @param StudyClassId $id
     */
    private function __construct(StudyClassId $id)
    {
        $this->id = $id;
    }

    /**
     * @return StudyClassId
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param StudyClassId $id
     * @param StudentGroupId $studentGroup
     * @param Date $date
     * @param Time $time
     * @param PricePerHour $pricePerHour
     * @param GroupClassDuration $duration
     * @return StudyClass
     */
    public static function give(
        StudyClassId $id,
        StudentGroupId $studentGroup,
        Date $date,
        Time $time,
        PricePerHour $pricePerHour,
        GroupClassDuration $duration
    ) {
        $studyClass = new StudyClass($id);

        $studyClass->recordThat(new StudyClassWasGiven(
            $id,
            $studentGroup,
            $date,
            $time,
            $pricePerHour,
            $duration
        ));

        return $studyClass;
    }

    /**
     * @param StudyClassWasGiven $event
     */
    public function whenStudyClassWasGiven(StudyClassWasGiven $event)
    {
        $this->studentGroup = $event->studentGroupId();
        $this->date = $event->date();
        $this->time = $event->time();
        $this->pricePerHour = $event->pricePerHour();
        $this->duration = $event->duration();
    }

    /**
     * @param Student $student
     * @param string $status
     * @return $this
     * @throws StudentWasAlreadyAddedToStudyClass
     */
    public function addStudent(Student $student, string $status)
    {
        if($this->studentAlreadyAdded($student)) {
            throw new StudentWasAlreadyAddedToStudyClass();
        }

        $this->recordThat(new StudentWasAddedToStudyClass(
            $this->id,
            $student->id(),
            $status,
            $this->studentGroupId(),
            $this->studyDate(),
            $this->pricePerHour,
            $this->duration
        ));

        return $this;
    }

    /**
     * @param StudentWasAddedToStudyClass $event
     * @throws Exception\InvalidArgumentException
     */
    public function whenStudentWasAddedToStudyClass(StudentWasAddedToStudyClass $event)
    {
        $this->studyStudents[(string)$event->studentId()] = new StudentClassStatus($event->studentId(), $event->status());
    }

    /**
     * @return StudentGroupId
     */
    public function studentGroupId()
    {
        return $this->studentGroup;
    }

    /**
     * @return Date
     */
    public function studyDate()
    {
        return $this->date;
    }

    /**
     * @return PricePerHour
     */
    public function pricePerHour()
    {
        return $this->pricePerHour;
    }

    /**
     * @return GroupClassDuration
     */
    public function duration()
    {
        return $this->duration;
    }

    /**
     * @return float|int
     */
    public function price()
    {
        return $this->pricePerHour->value() * $this->duration->value();
    }

    /**
     * @return Time
     */
    public function time()
    {
        return $this->time;
    }

    /**
     * @param $student
     * @return bool
     */
    public function studentAlreadyAdded(Student $student)
    {
        return isset($this->studyStudents[(string)$student->id()]);
    }

    /**
     * @return int
     */
    public function studentsCount()
    {
        return count($this->studyStudents);
    }
}
