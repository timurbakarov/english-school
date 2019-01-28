<?php

namespace App\Http\Controllers;

use App\Repository\StudyClassReadModel;

class StudyClassesController
{
    public function __invoke(StudyClassReadModel $studyClassReadModel)
    {
        $classes = $studyClassReadModel->orderBy('date', 'DESC')->get();

        return view('study-classes.list', compact('classes'));
    }
}
