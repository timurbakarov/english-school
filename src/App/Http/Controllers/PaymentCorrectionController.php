<?php

namespace App\Http\Controllers;

use Domain\Contract\CommandBus;
use Domain\Finance\Student\Command\CancelPaymentCommand;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;

class PaymentCorrectionController
{
    use DispatchesJobs;

//    public function returnPayment(string $id, Request $request)
//    {
//        $this->dispatch(new ReturnPayment(
//            $request->post('student_id'),
//            $id,
//            $request->post('comment') ?? ''
//        ));
//
//        return redirect()->back();
//    }

    public function cancelPayment(string $id, Request $request, CommandBus $commandBus)
    {
        $commandBus->dispatch(new CancelPaymentCommand($request->post('student_id'), $id, $request->post('comment')));

        return redirect()->back();
    }
}
