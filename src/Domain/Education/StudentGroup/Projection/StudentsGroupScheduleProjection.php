<?php

namespace Domain\Education\StudentGroup\Projection;

use Domain\BaseProjection;
use Domain\Education\StudentGroup\Schedule;
use App\Repository\StudentsGroupScheduleReadModel;
use Domain\Education\StudentGroup\Schedule\ScheduleItem;
use Domain\Education\StudentGroup\Event\StudentGroupWasCreated;
use Domain\Education\StudentGroup\Event\StudentGroupScheduleWasChanged;

class StudentsGroupScheduleProjection extends BaseProjection
{
    /**
     * @var StudentsGroupScheduleReadModel
     */
    private $groupScheduleReadModel;

    /**
     * StudentsGroupScheduleProjection constructor.
     * @param StudentsGroupScheduleReadModel $groupScheduleReadModel
     */
    public function __construct(StudentsGroupScheduleReadModel $groupScheduleReadModel)
    {
        $this->groupScheduleReadModel = $groupScheduleReadModel;
    }

    /**
     * @return array
     */
    public function events(): array
    {
        return [
            StudentGroupWasCreated::class,
            StudentGroupScheduleWasChanged::class,
        ];
    }

    public function whenStudentGroupWasCreated(StudentGroupWasCreated $event)
    {
        $this->saveSchedule((string)$event->getAggregateId(), $event->schedule());
    }

    public function whenStudentGroupScheduleWasChanged(StudentGroupScheduleWasChanged $event)
    {
        $this->groupScheduleReadModel->where('group_id', $event->getAggregateId())->delete();

        $this->saveSchedule((string)$event->getAggregateId(), $event->schedule());
    }

    private function saveSchedule($groupId, Schedule $schedule)
    {
        foreach($schedule->items() as $scheduleItem) {
            $this->saveScheduleItem($groupId, $scheduleItem);
        }
    }

    private function saveScheduleItem($groupId, ScheduleItem $scheduleItem)
    {
        $scheduleItemRow = $this->groupScheduleReadModel->newInstance();

        $scheduleItemRow->group_id = $groupId;
        $scheduleItemRow->day_of_week = (string)$scheduleItem->dayOfWeek();
        $scheduleItemRow->hour = (string)$scheduleItem->time()->hour();
        $scheduleItemRow->minutes = (string)$scheduleItem->time()->minutes();
        $scheduleItemRow->duration = (string)$scheduleItem->duration();

        $scheduleItemRow->save();
    }

    /**
     * @return mixed
     */
    public function readModel()
    {
        return $this->groupScheduleReadModel;
    }
}
