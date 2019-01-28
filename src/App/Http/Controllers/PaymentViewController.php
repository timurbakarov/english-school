<?php

namespace App\Http\Controllers;

use App\Repository\PaymentsReadModel;

class PaymentViewController
{
    public function __invoke(string $id, PaymentsReadModel $paymentsReadModel)
    {
        $payment = $paymentsReadModel->findOrFail($id);

        return view('payments.view', compact('payment'));
    }
}
