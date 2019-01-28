<?php

namespace App\PageData\Student;

class StudentProfileDataProvider
{
    public function __construct()
    {

    }

    /**
     * @param string $studentId
     * @return array
     */
    public function provide(string $studentId)
    {
        return [
            'lessons' => $this->classes($studentId)->map(function($lesson) use($studentId) {
                return [
                    'status' => $lesson->status,
                    'date' => date_formatted($lesson->date),
                    'group_name' => $lesson->groupName,
                    'is_payed' => $lesson->is_payed,
                    'payment' => $lesson->payment,
                ];
            }),
        ];
    }

    private function classes($studentId)
    {
        return \DB::table('students_classes')
            ->select(
                'students_classes.status',
                'students_classes.is_payed',
                'students_classes.payment',
                'groups.name AS groupName',
                'study_classes.date',
                'study_classes.study_class_id AS lesson_id',
                'study_classes.duration',
                'study_classes.price_per_hour'
            )
            ->where('student_id', $studentId)
            ->join('study_classes', 'students_classes.study_class_id', '=', 'study_classes.study_class_id')
            ->join('groups', 'groups.id', '=', 'study_classes.group_id')
            ->orderBy('study_classes.date', 'DESC')
            ->get();
    }
}
