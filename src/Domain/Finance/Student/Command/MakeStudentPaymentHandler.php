<?php

namespace Domain\Finance\Student\Command;

use Domain\Date;
use Domain\StudentId;
use Domain\Finance\Student;
use Illuminate\Contracts\Events\Dispatcher;
use Infr\Repository\GeneralRepository;

class MakeStudentPaymentHandler
{
    /**
     * @var GeneralRepository
     */
    private $repository;

    /**
     * @var Dispatcher
     */
    private $eventDispatcher;

    /**
     * @param GeneralRepository $repository
     * @param Dispatcher $eventDispatcher
     */
    public function __construct(GeneralRepository $repository, Dispatcher $eventDispatcher)
    {
        $this->repository = $repository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(MakeStudentPaymentCommand $command)
    {
        /** @var Student $student */
        $student = $this->repository->get(StudentId::fromString($command->studentId()), 'finance');

        $student->makePayment(
            new Student\PaymentAmount($command->amount()),
            Student\PaymentType::fromString($command->type()),
            Date::fromString($command->payedOn())
        );

        $events = $student->getRecordedEvents();

        $this->repository->add($student);

        foreach($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
