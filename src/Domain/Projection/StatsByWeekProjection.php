<?php

namespace Domain\Projection;

use Domain\BaseProjection;
use Domain\Event\StudentBalanceWasCorrectedDueToPaymentCorrection;
use Domain\Event\StudyClassWasGiven;
use App\Repository\StatsByWeekReadModel;
use Domain\Finance\Student\Event\PaymentWasCancelled;
use Domain\Finance\Student\Event\StudentMadePayment;

class StatsByWeekProjection extends BaseProjection
{
    /**
     * @var StatsByWeekReadModel
     */
    private $statsByWeekReadModel;

    /**
     * StatsByWeekProjection constructor.
     * @param StatsByWeekReadModel $statsByWeekReadModel
     */
    public function __construct(StatsByWeekReadModel $statsByWeekReadModel)
    {
        $this->statsByWeekReadModel = $statsByWeekReadModel;
    }

    /**
     * @return array
     */
    public function events(): array
    {
        return [
            StudentMadePayment::class,
            PaymentWasCancelled::class,
            //StudyClassWasGiven::class,
        ];
    }

    public function whenStudentMadePayment(StudentMadePayment $event)
    {
        $paymentDate = $event->payedOn()->value();

        $year = $paymentDate->format('Y');
        $month = $paymentDate->format('m');
        $week = $paymentDate->format('W');

        $row = $this->row($year, $month, $week);

        $row->income = $row->income + $event->amount()->value();

        $row->save();
    }

    public function whenPaymentWasCancelled(PaymentWasCancelled $event)
    {
        $paymentDate = $event->payedOn()->value();

        $year = $paymentDate->format('Y');
        $month = $paymentDate->format('m');
        $week = $paymentDate->format('W');

        $row = $this->row($year, $month, $week);

        $row->income = $row->income - $event->amount()->value();

        $row->save();
    }

//    public function whenStudyClassWasGiven(StudyClassWasGiven $event)
//    {
//        $date = $event->date()->value();
//
//        $year = $date->format('Y');
//        $month = $date->format('m');
//        $week = $date->format('W');
//
//        $row = $this->row($year, $month, $week);
//
//        $studentsCount = $event->studyStudents()->countByStatus('visited');
//
//        $row->hours_worked = $row->hours_worked + $event->duration()->value();
//        $row->hours_student_worked = $row->hours_student_worked + $event->duration()->value() * $studentsCount;
//        $row->money_worked = $row->money_worked + $event->pricePerHour()->value() * $event->duration()->value() * $studentsCount;
//
//        $row->save();
//    }

    /**
     * @param $year
     * @param $week
     * @return mixed
     */
    private function row($year, $month, $week)
    {
        $row = $this->statsByWeekReadModel
            ->where('year', $year)
            ->where('month', $month)
            ->where('week', $week)
            ->first();

        if(!$row) {
            $row = $this->statsByWeekReadModel->newInstance();
            $row->year = $year;
            $row->week = $week;
            $row->month = $month;
        }

        return $row;
    }

    /**
     * @return mixed
     */
    public function readModel()
    {
        return $this->statsByWeekReadModel;
    }
}
