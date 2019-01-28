<?php

namespace App\Http\Controllers;

use App\Query\ActiveStudentsQuery;
use App\Repository\StudentReadModel;
use App\TableFilter\StudentsTableFilter;

class StudentsList
{
    public function __invoke(StudentsTableFilter $filter, StudentReadModel $studentRepository)
    {
        $students = $studentRepository
            ->withQuery(new ActiveStudentsQuery($filter))
            ->orderBy('last_name', 'ASC')->with('group')
            ->get();

        return view('students.list', compact('students', 'filter'));
    }
}
