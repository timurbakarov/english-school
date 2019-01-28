<?php

namespace Domain\Education;

use Domain\Date;
use Domain\AggregateRoot;
use Domain\Contract\RecordsEvents;
use Domain\Contract\IsEventSourced;
use Domain\Education\StudentGroup\Schedule;
use Domain\Education\StudentGroup\PricePerHour;
use Domain\Education\StudentGroup\StudentGroupName;
use Domain\Education\StudentGroup\Event\StudentGroupNameWasChanged;
use Domain\Education\StudentGroup\Event\StudentGroupScheduleWasChanged;
use Domain\Education\StudentGroup\Event\StudentGroupPricePerHourWasChanged;

class StudentGroup implements RecordsEvents, IsEventSourced
{
    use AggregateRoot;

    /**
     * @var StudentGroup\StudentGroupId
     */
    private $id;

    /**
     * @var StudentGroupName
     */
    private $name;

    /**
     * @var PricePerHour
     */
    private $pricePerHour;

    /**
     * @var StudentGroup\Schedule
     */
    private $schedule;

    /**
     * StudentGroup constructor.
     * @param StudentGroup\StudentGroupId $id
     */
    private function __construct(StudentGroup\StudentGroupId $id)
    {
        $this->id = $id;
    }

    /**
     * @param StudentGroup\StudentGroupId $id
     * @param Schedule $schedule
     * @param StudentGroup\StudentGroupName $name
     * @param StudentGroup\PricePerHour $pricePerHour
     * @param Date|null $createdDate
     * @return StudentGroup
     */
    public static function create(
        StudentGroup\StudentGroupId $id,
        Schedule $schedule,
        StudentGroup\StudentGroupName $name,
        StudentGroup\PricePerHour $pricePerHour,
        Date $createdDate = null
    ) {
        $createdDate = $createdDate ?? Date::now();

        $studentGroup = new self($id);

        $studentGroup->recordThat(
            new StudentGroup\Event\StudentGroupWasCreated($id, $schedule, $name, $pricePerHour, $createdDate)
        );

        return $studentGroup;
    }

    /**
     * @param StudentGroup\Event\StudentGroupWasCreated $event
     */
    private function whenStudentGroupWasCreated(StudentGroup\Event\StudentGroupWasCreated $event)
    {
        $this->name = $event->name();
        $this->schedule = $event->schedule();
        $this->pricePerHour = $event->pricePerHour();
    }

    /**
     * @param StudentGroupName $name
     * @param Date|null $changedOn
     * @return $this
     */
    public function changeName(StudentGroupName $name, Date $changedOn = null)
    {
        if($this->name->equals($name)) {
            return $this;
        }

        $changedOn = $changedOn ?? Date::now();

        $this->recordThat(new StudentGroupNameWasChanged($this->id, $name, $changedOn));

        return $this;
    }

    /**
     * @param StudentGroupNameWasChanged $event
     */
    public function whenStudentGroupNameWasChanged(StudentGroupNameWasChanged $event)
    {
        $this->name = $event->name();
    }

    /**
     * @param StudentGroup\Schedule $schedule
     * @return $this
     */
    public function changeSchedule(StudentGroup\Schedule $schedule)
    {
        if($this->schedule AND $schedule->equals($this->schedule)) {
            return $this;
        }

        $changedOn = Date::now();

        $this->recordThat(new StudentGroupScheduleWasChanged($this->id, $schedule, $changedOn));

        return $this;
    }

    /**
     * @param StudentGroupScheduleWasChanged $event
     */
    private function whenStudentGroupScheduleWasChanged(StudentGroupScheduleWasChanged $event)
    {
        $this->schedule = $event->schedule();
    }

    /**
     * @param PricePerHour $pricePerHour
     * @return $this
     */
    public function changePricePerHour(PricePerHour $pricePerHour)
    {
        if($this->pricePerHour->equals($pricePerHour)) {
            return $this;
        }

        $changedOn = Date::now();

        $this->recordThat(new StudentGroupPricePerHourWasChanged($this->id, $pricePerHour, $changedOn));

        return $this;
    }

    /**
     * @param StudentGroupPricePerHourWasChanged $event
     */
    private function whenStudentGroupPricePerHourWasChanged(StudentGroupPricePerHourWasChanged $event)
    {
        $this->pricePerHour = $event->pricePerHour();
    }

    /**
     * @return StudentGroup\StudentGroupId
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return PricePerHour
     */
    public function pricePerHour()
    {
        return $this->pricePerHour;
    }
}
