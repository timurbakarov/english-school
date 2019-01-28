<?php

namespace App\Http\Controllers\Journal;

use App\Repository\StudentsGroupReadModel;

class JournalGroupsController
{
    public function __invoke(StudentsGroupReadModel $studentsGroupReadModel)
    {
        $groups = $studentsGroupReadModel->orderBy('name', 'ASC')->get();

        return view('journal.groups', compact('groups'));
    }
}
