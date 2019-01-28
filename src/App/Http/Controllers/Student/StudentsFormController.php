<?php

namespace App\Http\Controllers\Student;

use App\Repository\StudentReadModel;
use App\Repository\StudentsGroupReadModel;

class StudentsFormController
{
    public function __invoke(string $id = null, StudentReadModel $studentReadModel, StudentsGroupReadModel $studentsGroupReadModel)
    {
        $student = $id ? $this->student($id, $studentReadModel) : null;
        $groups = $studentsGroupReadModel->all();

        return view('students.form', compact('student', 'groups'));
    }

    /**
     * @param string $id
     * @param StudentReadModel $studentReadModel
     * @return null
     */
    private function student(string $id, StudentReadModel $studentReadModel)
    {
        $student = $studentReadModel->find($id);

        if(!$student) {
            abort(404);
        }

        return $student;
    }
}
