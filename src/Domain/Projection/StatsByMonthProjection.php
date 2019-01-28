<?php

namespace Domain\Projection;

use Domain\BaseProjection;
use App\Repository\StatsByMonthReadModel;
use Domain\Finance\Student\Event\StudentMadePayment;
use Domain\Finance\Student\Event\PaymentWasCancelled;

class StatsByMonthProjection extends BaseProjection
{
    /**
     * @var StatsByMonthReadModel
     */
    private $statsByMonthReadModel;

    /**
     * StatsByMonthProjection constructor.
     * @param StatsByMonthReadModel $statsByMonthReadModel
     */
    public function __construct(StatsByMonthReadModel $statsByMonthReadModel)
    {
        $this->statsByMonthReadModel = $statsByMonthReadModel;
    }

    /**
     * @return array
     */
    public function events(): array
    {
        return [
            StudentMadePayment::class,
            PaymentWasCancelled::class,
        ];
    }

    public function whenStudentMadePayment(StudentMadePayment $event)
    {
        $paymentDate = $event->payedOn()->value();

        $year = $paymentDate->format('Y');
        $month = $paymentDate->format('m');

        $row = $this->row($year, $month);

        $row->income = $row->income + $event->amount()->value();

        $row->save();
    }

    public function whenPaymentWasCancelled(PaymentWasCancelled $event)
    {
        $paymentDate = $event->payedOn()->value();

        $year = $paymentDate->format('Y');
        $month = $paymentDate->format('m');

        $row = $this->row($year, $month);

        $row->income = $row->income - $event->amount()->value();

        $row->save();
    }

//    public function whenStudyClassWasGiven(StudyClassWasGiven $event)
//    {
//        $date = $event->date()->value();
//
//        $year = $date->format('Y');
//        $month = $date->format('m');
//
//        $row = $this->row($year, $month);
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
     * @param $month
     * @return static
     */
    private function row($year, $month)
    {
        $row = $this->statsByMonthReadModel
            ->where('year', $year)
            ->where('month', $month)
            ->first();

        if(!$row) {
            $row = $this->statsByMonthReadModel->newInstance();
            $row->year = $year;
            $row->month = $month;
        }

        return $row;
    }

    /**
     * @return mixed
     */
    public function readModel()
    {
        return $this->statsByMonthReadModel;
    }
}
