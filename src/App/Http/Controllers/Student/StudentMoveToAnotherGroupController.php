<?php

namespace App\Http\Controllers\Student;

use Domain\HumanResource\Student\Command\MoveStudentToAnotherGroupCommand;
use Illuminate\Http\Request;
use Domain\Contract\CommandBus;

class StudentMoveToAnotherGroupController
{
    public function __invoke(string $id, Request $request, CommandBus $commandBus)
    {
        $commandBus->dispatch(new MoveStudentToAnotherGroupCommand(
            $id,
            $request->post('group_id'),
            $request->post('assigned_on')
        ));

        return redirect()->back();
    }
}
