<?php

namespace App\Http\Controllers;

use App\Repository\PaymentsReadModel;
use Domain\Finance\Student\PaymentStatus;

class PaymentsListController
{
    public function __invoke(PaymentsReadModel $paymentsReadModel)
    {
        $payments = $paymentsReadModel
            ->orderByRaw('date DESC, order_number DESC')
            ->with('student')
            ->get();

        $total = $paymentsReadModel
            ->where('status', PaymentStatus::STATUS_CREATED)
            ->sum('amount');

        return view('payments.list', compact('payments', 'total'));
    }
}
