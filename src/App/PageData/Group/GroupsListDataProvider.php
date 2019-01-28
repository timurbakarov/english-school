<?php

namespace App\PageData\Group;

use App\Repository\StudentsGroupReadModel;
use Presentation\Schedule\ScheduleItemPresentation;

class GroupsListDataProvider
{
    /**
     * @var StudentsGroupReadModel
     */
    private $studentGroupReadModel;

    /**
     * @var ScheduleItemPresentation
     */
    private $scheduleTimePresentation;

    /**
     * @param StudentsGroupReadModel $studentGroupReadModel
     * @param ScheduleItemPresentation $scheduleTimePresentation
     */
    public function __construct(StudentsGroupReadModel $studentGroupReadModel, ScheduleItemPresentation $scheduleTimePresentation)
    {
        $this->studentGroupReadModel = $studentGroupReadModel;
        $this->scheduleTimePresentation = $scheduleTimePresentation;
    }

    public function provide()
    {
        $groups = $this->studentGroupReadModel->orderBy('name', 'ASC')->get();

        return [
            'groupsCount' => $groups->count(),
            'groupsTable' => [
                'rows' => $groups->map(function($group, $index) {
                    return [
                        'index' => $index + 1,
                        'name' => $group->name,
                        'students_count' => $group->students_count ?? 0,
                        'price_per_hour' => $group->price_per_hour,
                        'schedule' => $group->schedule->map(function($schedule) {
                            return [
                                'day' => $this->scheduleTimePresentation->nameOfDayOfWeek($schedule->day_of_week),
                                'hour' => $schedule->hour,
                                'minutes' => str_pad($schedule->minutes, 2, '0', STR_PAD_RIGHT),
                            ];
                        }),
                        'edit_url' => url('groups/edit', $group->id),
                        'view_url' => url('groups/view', $group->id),
                    ];
                }),
            ],
        ];
    }
}
