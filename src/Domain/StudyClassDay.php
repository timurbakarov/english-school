<?php

namespace Domain;

use Domain\Contract\RecordsEvents;
use Domain\Contract\IsEventSourced;
use Domain\StudyClass\StudyClassId;
use Domain\StudyClassDay\StudyClassDayId;
use Domain\Event\StudyClassWasAddedToDay;
use Domain\Exception\StudyClassTimeOverlapped;
use Domain\Exception\StudyClassBelongsToAnotherDay;
use Domain\Exception\StudyClassWasAlreadyAddedException;

class StudyClassDay implements RecordsEvents, IsEventSourced
{
    use RecordEventsTrait;
    use EventSourcedTrait;

    /**
     * @var StudyClassDayId
     */
    private $id;

    /**
     * @var array
     */
    private $studyClasses = [];

    /**
     * StudyClassDay constructor.
     * @param StudyClassDayId $id
     */
    private function __construct(StudyClassDayId $id)
    {
        $this->id = $id;
    }

    /**
     * @param Date $date
     * @return StudyClassDay
     */
    public static function getFromDate(Date $date)
    {
        return new self(StudyClassDayId::fromDate($date));
    }

    /**
     * @param StudyClass $studyClass
     * @return $this
     * @throws Exception\InvalidArgumentException
     * @throws StudyClassBelongsToAnotherDay
     * @throws StudyClassTimeOverlapped
     * @throws StudyClassWasAlreadyAddedException
     */
    public function addStudyClass(StudyClass $studyClass)
    {
        if($this->studyClassAlreadyExist($studyClass)) {
            throw new StudyClassWasAlreadyAddedException;
        }

        if($this->studyClassFromAnotherDay($studyClass)) {
            throw new StudyClassBelongsToAnotherDay();
        }

        $timeInterval = TimeInterval::fromTimeAndDuration($studyClass->time(), $studyClass->duration()->value());

        if($this->studyClassTimeOverlapped($timeInterval)) {
            throw new StudyClassTimeOverlapped();
        }

        $this->recordThat(new StudyClassWasAddedToDay(
            $this->id,
            $studyClass->id(),
            $timeInterval
        ));

        return $this;
    }

    /**
     * @param StudyClassWasAddedToDay $event
     */
    public function whenStudyClassWasAddedToDay(StudyClassWasAddedToDay $event)
    {
        $this->studyClasses[(string)$event->studyClassId()] = [
            'time_interval' => $event->timeInterval(),
        ];
    }

    /**
     * @return StudyClassDayId
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function studyClassesCount()
    {
        return count($this->studyClasses);
    }

    /**
     * @param StudyClass $studyClass
     * @return bool
     */
    private function studyClassAlreadyExist(StudyClass $studyClass)
    {
        return array_key_exists((string)$studyClass->id(), $this->studyClasses);
    }

    /**
     * @param StudyClass $studyClass
     * @return bool
     */
    private function studyClassFromAnotherDay(StudyClass $studyClass)
    {
        return !$this->id->equals(StudyClassDayId::fromDate($studyClass->studyDate()));
    }

    /**
     * @param TimeInterval $timeInterval
     * @return bool
     */
    private function studyClassTimeOverlapped(TimeInterval $timeInterval)
    {
        foreach($this->studyClasses as $item) {
            if($timeInterval->isOverlapped($item['time_interval'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param TimeInterval $timeInterval
     * @return bool|Contract\IdentifiesAggregate|static
     */
    public function getStudyClassIdByTimeInterval(TimeInterval $timeInterval)
    {
        foreach($this->studyClasses as $studyClassId => $studyClass) {
            if($timeInterval->equals($studyClass['time_interval'])) {
                return StudyClassId::fromString($studyClassId);
            }
        }

        return false;
    }
}
