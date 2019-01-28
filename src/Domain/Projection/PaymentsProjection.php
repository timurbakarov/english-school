<?php

namespace Domain\Projection;

use Domain\BaseProjection;
use Domain\Event\PaymentWasReturned;
use App\Repository\PaymentsReadModel;
use Domain\Event\PaymentWasCancelledDueToMistake;
use Domain\Finance\Student\Event\PaymentWasCancelled;
use Domain\Finance\Student\Event\StudentMadePayment;
use Domain\Finance\Student\PaymentStatus;

class PaymentsProjection extends BaseProjection
{
    /**
     * @var PaymentsReadModel
     */
    private $paymentsReadModel;

    /**
     * PaymentsProjection constructor.
     * @param PaymentsReadModel $paymentsReadModel
     */
    public function __construct(PaymentsReadModel $paymentsReadModel)
    {
        $this->paymentsReadModel = $paymentsReadModel;
    }

    /**
     * @return array
     */
    public function events(): array
    {
        return [
            StudentMadePayment::class,
            PaymentWasCancelled::class,
//            PaymentWasReturned::class,
//            PaymentWasCancelledDueToMistake::class,
        ];
    }

    public function whenStudentMadePayment(StudentMadePayment $event)
    {
        $totalPayments = $this->paymentsReadModel->count();

        $payment = $this->paymentsReadModel->newInstance();

        $payment->payment_id = (string)$event->paymentId();
        $payment->date = (string)$event->payedOn();
        $payment->amount = (string)$event->amount();
        $payment->type = (string)$event->type();
        $payment->status = PaymentStatus::STATUS_CREATED;
        $payment->order_number = $totalPayments + 1;
        $payment->student_id = (string)$event->getAggregateId();

        $payment->save();
    }

    public function whenPaymentWasCancelled(PaymentWasCancelled $event)
    {
        $payment = $this->paymentsReadModel->findOrFail((string)$event->paymentId());
        $payment->status = PaymentStatus::STATUS_CANCELLED_DUE_TO_MISTAKE;
        $payment->save();
    }

//    public function whenPaymentWasReturned(PaymentWasReturned $event)
//    {
//        $payment = $this->paymentsReadModel->findOrFail((string)$event->getAggregateId());
//        $payment->status = PaymentStatus::STATUS_RETURNED;
//        $payment->save();
//    }

    /**
     * @return mixed
     */
    public function readModel()
    {
        return $this->paymentsReadModel;
    }
}
