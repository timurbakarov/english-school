<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Domain\Contract\CommandBus;
use App\Http\Controllers\StudentsList;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Domain\HumanResource\Student\Command\AcceptStudentCommand;

class StudentAcceptController
{
    use ValidatesRequests;

    public function __invoke(Request $request, CommandBus $commandBus)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => '',
            'phone' => 'required',
            'group_id' => '',
            'parents' => '',
            'accepted_date' => '',
        ];

        $this->validate($request, $rules);

        $input = $request->only(array_keys($rules));

        $commandBus->dispatch(new AcceptStudentCommand(
            $input['first_name'],
            $input['last_name'],
            $input['group_id'],
            $input['email'] ?? null,
            $input['phone'],
            $input['accepted_date'],
            $input['parents'] ?? ''
        ));

        return redirect(action(StudentsList::class));
    }
}
