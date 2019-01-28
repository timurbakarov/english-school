<?php

namespace Domain\Exception;

use Domain\Payment\PaymentId;
use Domain\StudentId;

class PaymentDoesNotBelongToStudent extends \Exception
{
    public static function create(PaymentId $paymentId, StudentId $studentId)
    {
        return new self("Payment [$paymentId] does not belong to student [$studentId]");
    }
}
