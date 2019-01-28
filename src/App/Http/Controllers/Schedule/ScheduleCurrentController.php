<?php

namespace App\Http\Controllers\Schedule;

use App\Repository\StudentsGroupReadModel;
use Presentation\Schedule\ScheduleCurrentTable;
use App\Repository\StudentsGroupScheduleReadModel;

class ScheduleCurrentController
{
    public function __invoke(
        StudentsGroupScheduleReadModel $groupScheduleReadModel,
        StudentsGroupReadModel $studentsGroupReadModel
    ) {
        $groups = $studentsGroupReadModel->where('students_count', '>', 0)->get();

        $groupsIds = $groups->map(function($group) {
            return $group->id;
        });

        $scheduleItems = $groupScheduleReadModel
            ->orderBy('hour', 'ASC')
            ->with('group')
            ->whereIn('group_id', $groupsIds)
            ->get();

        $scheduleCurrentTable = new ScheduleCurrentTable($scheduleItems);

        return view('schedule.current', compact('scheduleCurrentTable'));
    }
}
