<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Domain\Contract\CommandBus;
use Domain\HumanResource\Student\Command\DismissStudentCommand;

class StudentsDismissController
{
    public function __invoke(string $id = null, Request $request, CommandBus $commandBus)
    {
        $commandBus->dispatch(new DismissStudentCommand(
            $id,
            $request->post('dismissed_on'),
            $request->post('reason')
        ));

        return redirect('students');
    }
}
