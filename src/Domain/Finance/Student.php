<?php

namespace Domain\Finance;

use Domain\Date;
use Domain\HumanResource\Student\Event\StudentWasDismissed;
use Domain\HumanResource\Student\Exception\StudentIsDismissedException;
use Domain\LessonId;
use Domain\StudentId;
use Domain\AggregateRoot;
use Domain\Education\Lesson;
use Domain\Contract\RecordsEvents;
use Domain\Contract\IsEventSourced;
use Domain\Finance\Student\PaymentId;
use Domain\Finance\Student\PaymentType;
use Domain\Finance\Student\PaymentAmount;
use Domain\HumanResource\Student\Balance;
use Domain\Finance\Student\Event\StudentMadePayment;
use Domain\Finance\Student\Event\StudentPaidOffDebt;
use Domain\Finance\Student\Event\PaymentWasCancelled;
use Domain\Finance\Student\Event\StudentPaidForLesson;
use Domain\Finance\Student\Exception\PaymentWasNotFound;
use Domain\Finance\Student\Event\StudentGotDebtForLesson;
use Domain\Finance\Student\Exception\StudentBalanceIsNotEnough;
use Domain\Finance\Student\Exception\StudentAlreadyPaidForLessonOrHasDebtException;

class Student implements RecordsEvents, IsEventSourced
{
    use AggregateRoot;

    /**
     * @var StudentId
     */
    private $id;

    /**
     * @var Balance
     */
    private $balance;

    /**
     * @var array
     */
    private $payments = [];

    /**
     * @var array
     */
    private $payedLessons = [];

    /**
     * @var array
     */
    private $debts = [];

    /**
     * @param StudentId $studentId
     */
    private function __construct(StudentId $studentId)
    {
        $this->id = $studentId;
        $this->balance = new Balance(0);
    }

    /**
     * @param PaymentAmount $amount
     * @param PaymentType $type
     * @param Date $payedOn
     * @return $this
     */
    public function makePayment(PaymentAmount $amount, PaymentType $type, Date $payedOn)
    {
        $paymentId = PaymentId::generate();

        $this->recordThat(new StudentMadePayment($this->id, $paymentId, $amount, $type, $payedOn));

        return $this;
    }

    private function whenStudentMadePayment(StudentMadePayment $event)
    {
        $this->balance->increase($event->amount()->value());
        $this->payments[(string)$event->paymentId()] = [
            'status' => 'paid',
            'amount' => $event->amount()->value(),
            'payed_on' => $event->payedOn(),
        ];
    }

    /**
     * @param PaymentId $paymentId
     * @param string $comment
     * @return $this
     * @throws PaymentWasNotFound
     * @throws StudentBalanceIsNotEnough
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public function cancelPayment(PaymentId $paymentId, string $comment)
    {
        if(!$this->paymentExists($paymentId)) {
            throw new PaymentWasNotFound('Student does not have this payment');
        }

        $payment = $this->getPayment($paymentId);

        if($payment['status'] == 'cancelled') {
            return $this;
        }

        if($this->balance->value() < $payment['amount']) {
            throw new StudentBalanceIsNotEnough('Student does not have enough balance to cancel payment');
        }

        $amount = new PaymentAmount($payment['amount']);

        $this->recordThat(new PaymentWasCancelled(
            $this->id,
            $paymentId,
            $amount,
            $comment,
            Date::now(),
            $payment['payed_on']
        ));

        return $this;
    }

    private function whenPaymentWasCancelled(PaymentWasCancelled $event)
    {
        $this->balance->reduce($event->amount()->value());
        $this->payments[(string)$event->paymentId()]['status'] = 'cancelled';
        $this->payments[(string)$event->paymentId()]['cancelled_on'] = $event->cancelledOn();
    }

    /**
     * @param Lesson $lesson
     * @return $this
     * @throws \Domain\Exception\InvalidArgumentException
     * @throws StudentAlreadyPaidForLessonOrHasDebtException
     */
    public function payForLesson(Lesson $lesson)
    {
        if($this->payedForLessonOrHasDebt($lesson->id())) {
            throw new StudentAlreadyPaidForLessonOrHasDebtException();
        }

        $amount = new PaymentAmount($lesson->price());

        if($this->balance->value() >= $amount->value()) {
            $this->recordThat(new StudentPaidForLesson($this->id, $lesson->id(), $amount, $lesson->date()));
        } else {
            $this->recordThat(new StudentGotDebtForLesson($this->id, $lesson->id(), $amount, $lesson->date()));
        }

        return $this;
    }

    private function whenStudentPaidForLesson(StudentPaidForLesson $event)
    {
        $this->balance->reduce($event->amount()->value());

        $this->payedLessons[] = (string)$event->lessonId();
    }

    private function whenStudentGotDebtForLesson(StudentGotDebtForLesson $event)
    {
        $this->debts[(string)$event->lessonId()] = [
            'lesson_id' => $event->lessonId(),
            'amount' => $event->amount(),
            'date' => $event->gotDebtOn(),
        ];

        $this->sortDebtsByDateAsc();
    }

    /**
     * @return $this
     */
    public function payOffDebts()
    {
        foreach($this->debts as $debt) {
            if($this->balance->hasEnough($debt['amount']->value())) {
                $this->recordThat(new StudentPaidOffDebt($this->id, $debt['lesson_id'], $debt['amount'], $debt['date']));
            } else {
                break;
            }
        }

        return $this;
    }

    private function whenStudentPaidOffDebt(StudentPaidOffDebt $event)
    {
        $this->balance->reduce($event->amount()->value());
        unset($this->debts[(string)$event->lessonId()]);
        $this->payedLessons[] = (string)$event->lessonId();
    }

    /**
     * @param LessonId $lessonId
     * @return bool
     */
    private function payedForLessonOrHasDebt(LessonId $lessonId)
    {
        if(in_array((string)$lessonId, $this->payedLessons)) {
            return true;
        }

        if(array_key_exists((string)$lessonId, $this->debts)) {
            return true;
        }

        return false;
    }

    /**
     * @param PaymentId $paymentId
     * @return bool
     */
    private function paymentExists(PaymentId $paymentId)
    {
        return isset($this->payments[(string)$paymentId]);
    }

    /**
     * @param PaymentId $paymentId
     * @return mixed
     */
    private function getPayment(PaymentId $paymentId)
    {
        return $this->payments[(string)$paymentId];
    }

    /**
     * @return int
     */
    public function balance()
    {
        return $this->balance->value();
    }

    /**
     * @return array
     */
    public function debts()
    {
        return $this->debts;
    }

    /**
     * @return $this
     */
    private function sortDebtsByDateAsc()
    {
        $resultDebts = [];
        $debts = array_values($this->debts);

        while(count($debts)) {
            $total = count($debts);

            $lowerIndex = 0;
            /** @var Date $lowerDebtDate */
            $lowerDebtDate = $debts[0]['date'];

            for($i=0; $i<$total; $i++) {
                if(!isset($debts[$i + 1])) {
                    break;
                }

                /** @var Date $compare */
                $compare = $debts[$i + 1]['date'];

                if($lowerDebtDate->isGreater($compare)) {
                    $lowerIndex = $i + 1;
                    $lowerDebtDate = $compare;
                }
            }

            $resultDebts[(string)$debts[$lowerIndex]['lesson_id']] = $debts[$lowerIndex];
            unset($debts[$lowerIndex]);
            $debts = array_values($debts);
        }

        $this->debts = $resultDebts;

        return $this;
    }
}
