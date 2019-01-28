<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Repository\StudentReadModel;
use App\Repository\StudyClassReadModel;
use Illuminate\Support\Collection;
use Presentation\Schedule\JournalTable;
use App\Repository\StudentClassReadModel;
use App\Repository\StudentsGroupReadModel;
use App\Repository\StudentByGroupAndDateReadModel;
use App\Repository\StudentsGroupScheduleReadModel;

class JournalController
{
    public function __invoke(
        string $id = null,
        int $year = null,
        int $month= null,
        StudentsGroupReadModel $groupsRepository,
        StudyClassReadModel $studyClassReadModel,
        StudentsGroupScheduleReadModel $studentsGroupScheduleReadModel,
        StudentClassReadModel $studentClassReadModel,
        StudentReadModel $studentReadModel,
        StudentByGroupAndDateReadModel $studentByGroupAndDateReadModel
    ) {
        $group = $id ? $groupsRepository->find($id) : $groupsRepository->first();

        if(!$group) {
            abort(404);
        }

        $year = $year ?: date('Y');
        $month = $month ?: date('n');

        $startDate = Carbon::createFromDate($year, $month, 1);
        $endDate = Carbon::createFromDate($year, $month, $startDate->format('t'));

        $schedule = $studentsGroupScheduleReadModel->where('group_id', $group->id)->get();
        $schedule = $schedule->groupBy('day_of_week')->toArray();

        $journalTable = new JournalTable($startDate, $endDate, $group->id, $schedule);

        $classes = $studyClassReadModel
            ->where('group_id', $group->id)
            ->orderBy('date', 'DESC')
            ->where('date', '>=', $journalTable->startDate()->format('Y-m-d'))
            ->where('date', '<=', $journalTable->endDate()->format('Y-m-d'))
            ->get()
            ->keyBy('study_class_id');

        $classesGroupByDate = $classes->groupBy('date');

        $classesIds = $classes->map(function($class) {
            return $class->study_class_id;
        });

        $studentClasses = $studentClassReadModel
            ->whereIn('study_class_id', $classesIds)
            ->get();

        $students = $this->students($year, $month, $group, $studentReadModel, $studentByGroupAndDateReadModel);

        $studentClasses = $this->groupByDateAndStudent($studentClasses, $classes);

        return view('journal', compact(
            'group',
            //'daysInMonth',
            //'currentMonthName',
            //'activeDate',
            //'today',
            //'prevMonth',
            //'nextMonth',
            //'groupClassesByDates',
            //'studentClassesByDates',
            'journalTable',
            'schedule',
            'classes',
            'classesGroupByDate',
            'studentClasses',
            'students'
        ));
    }

    /**
     * Выбираем студентов для текущего месяца
     *
     * Активные студенты
     * + студенты, которые посетили или пропустили занятие в этой группе в этом месяце
     *
     * @param $group
     * @param StudentReadModel $studentReadModel
     * @param StudentByGroupAndDateReadModel $studentByGroupAndDateReadModel
     * @return mixed
     */
    private function students(
        $year,
        $month,
        $group,
        StudentReadModel $studentReadModel,
        StudentByGroupAndDateReadModel $studentByGroupAndDateReadModel
    ) {
        $studentsIds = [];

        $rows = $studentReadModel->select('id')->where('group_id', $group->id)->get();

        foreach($rows as $row) {
            $studentsIds[] = $row->id;
        }

        $rows = $studentByGroupAndDateReadModel
            ->select('student_id')
            ->where('group_id', $group->id)
            ->where('year', $year)
            ->where('month', $month)
            ->get();

        foreach($rows as $row) {
            $studentsIds[] = $row->student_id;
        }

        return $studentReadModel->whereIn('id', $studentsIds)->get();
    }

    /**
     * @param $studentClasses
     * @param Collection $classes
     * @return array
     */
    private function groupByDateAndStudent($studentClasses, Collection $classes)
    {
        $items = [];

        foreach($studentClasses as $row) {
            $lesson = $classes->get($row->study_class_id);

            $items[$lesson->date][$lesson->hour . $lesson->minutes][$row->student_id] = $row;
        }

        return $items;
    }
}
