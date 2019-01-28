<?php

namespace App\Http\Controllers;

use App\Repository\StudentsGroupReadModel;

class GroupsForm
{
    public function __invoke($id = null, StudentsGroupReadModel $studentsGroupReadModel)
    {
        if(!is_null($id)) {
            $group = $studentsGroupReadModel->find($id);

            if(!$group) {
                abort(404);
            }
        } else {
            $group = null;
        }

        return view('groups.form', compact('group'));
    }
}
