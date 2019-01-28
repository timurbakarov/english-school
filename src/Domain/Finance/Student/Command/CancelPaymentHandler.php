<?php

namespace Domain\Finance\Student\Command;

use Domain\StudentId;
use Domain\Finance\Student;
use Infr\Repository\GeneralRepository;
use Illuminate\Contracts\Events\Dispatcher;

class CancelPaymentHandler
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

    /**
     * @param CancelPaymentCommand $command
     * @throws Student\Exception\PaymentWasNotFound
     * @throws Student\Exception\StudentBalanceIsNotEnough
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public function handle(CancelPaymentCommand $command)
    {
        /** @var Student $student */
        $student = $this->repository->get(StudentId::fromString($command->studentId()), 'finance');

        $student->cancelPayment(Student\PaymentId::fromString($command->paymentId()), $command->comment());

        $events = $student->getRecordedEvents();

        $this->repository->add($student);

        foreach($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
