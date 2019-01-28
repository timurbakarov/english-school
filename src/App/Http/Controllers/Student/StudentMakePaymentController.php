<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Domain\Contract\CommandBus;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Domain\Finance\Student\Command\MakeStudentPaymentCommand;

class StudentMakePaymentController
{
    use ValidatesRequests;

    public function __invoke(string $id, Request $request, CommandBus $commandBus)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
            'type' => '',
            'date' => '',
        ]);

        $commandBus->dispatch(new MakeStudentPaymentCommand(
            $id,
            $request->post('amount'),
            $request->post('type'),
            $request->post('date')
        ));

        return redirect()->back();
    }
}
