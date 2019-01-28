<?php

namespace App\Http\Controllers\Schedule;

use App\Repository\StudentsGroupReadModel;
use Presentation\Schedule\ScheduleGeneralTable;
use App\Repository\StudentsGroupScheduleReadModel;

class ScheduleGeneralController
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

        $scheduleGeneralTable = new ScheduleGeneralTable($scheduleItems);

        $totalClasses = $groupScheduleReadModel->count();
        $totalHours = $groupScheduleReadModel->sum('duration');
        $totalIncome = $this->totalIncome();

        return view('schedule.general', compact('scheduleGeneralTable', 'totalClasses', 'totalHours', 'totalIncome'));
    }

    private function totalIncome()
    {
        return \DB::table('groups')
            ->join('group_schedule', 'group_schedule.group_id', '=', 'groups.id')
            ->selectRaw('SUM(group_schedule.duration * groups.price_per_hour) AS total')
            ->first()->total;
    }
}
