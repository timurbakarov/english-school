<?php

namespace App\Http\Controllers;

use App\Repository\StudentReadModel;
use App\Repository\PaymentsReadModel;
use App\Repository\StudyClassReadModel;
use App\Repository\StudentClassReadModel;
use App\Repository\StudentsGroupReadModel;
use App\Repository\StudentsStatsReadModel;
use App\PageData\Student\StudentProfileDataProvider;

class StudentsViewController
{
    public function __invoke(
        string $id,
        StudentReadModel $studentRepository,
        StudentsGroupReadModel $studentsGroupReadModel,
        PaymentsReadModel $paymentsReadModel,
        StudentClassReadModel $studentClassReadModel,
        StudyClassReadModel $studyClassReadModel,
        StudentsStatsReadModel $studentsStatsReadModel,
        StudentProfileDataProvider $studentProfileDataProvider
    ) {
        $student = $studentRepository->with('group')->findOrFail($id);

        $groups = $studentsGroupReadModel->all();

        $payments = $paymentsReadModel->orderBy('date', 'DESC')->where('student_id', $id)->get();

        $stat = $studentsStatsReadModel->where('student_id', $id)->first();

        $data = $studentProfileDataProvider->provide($id);

        return view('students.view', array_merge(
            compact('student', 'groups', 'payments', 'stat'),
            $data
        ));
    }
}
