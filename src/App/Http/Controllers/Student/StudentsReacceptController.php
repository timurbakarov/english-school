<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Domain\Contract\CommandBus;
use Domain\HumanResource\Student\Command\ReacceptStudentCommand;

class StudentsReacceptController
{
    public function __invoke(string $id = null, Request $request, CommandBus $commandBus)
    {
        $commandBus->dispatch(new ReacceptStudentCommand(
            $id,
            $request->post('group_id'),
            $request->post('date')
        ));

        return redirect('students');
    }
}
