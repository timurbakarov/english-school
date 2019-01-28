<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Domain\Command\StudentMakePayment;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class StudentsPaymentController
{
    use DispatchesJobs;
    use ValidatesRequests;

    public function __invoke(string $id, Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
            'type' => '',
            'date' => '',
        ]);

        $this->dispatch(new StudentMakePayment(
            $id,
            $request->post('date'),
            $request->post('amount'),
            $request->post('type')
        ));

        return redirect()->back();
    }
}
