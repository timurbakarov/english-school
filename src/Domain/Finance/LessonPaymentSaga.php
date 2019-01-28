<?php

namespace Domain\Finance;

use Domain\Contract\CommandBus;
use Domain\Finance\Student\Event\StudentMadePayment;
use Domain\Finance\Student\Command\PayOffDebtsCommand;
use Domain\Education\Lesson\Event\StudentAttendedLesson;
use Domain\Finance\Student\Command\PayBillForLessonCommand;

class LessonPaymentSaga
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function whenStudentAttendedLesson(StudentAttendedLesson $event)
    {
        $this->commandBus->dispatch(new PayBillForLessonCommand($event->studentId(), $event->getAggregateId()));
    }

    public function whenStudentMadePayment(StudentMadePayment $event)
    {
        $this->commandBus->dispatch(new PayOffDebtsCommand($event->getAggregateId()));
    }

    /**
     * @return array
     */
    private function events()
    {
        return [
            StudentAttendedLesson::class,
            StudentMadePayment::class,
        ];
    }

    public function subscribe($events)
    {
        foreach($this->events() as $event) {
            $segments = explode('\\', $event);
            $eventName = end($segments);

            $events->listen($event, get_class($this) . '@when' . $eventName);
        }
    }
}
