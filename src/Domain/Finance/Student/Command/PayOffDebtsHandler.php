<?php

namespace Domain\Finance\Student\Command;

use Domain\StudentId;
use Domain\Finance\Student;
use Infr\Repository\GeneralRepository;
use Illuminate\Contracts\Events\Dispatcher;

class PayOffDebtsHandler
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

    public function handle(PayOffDebtsCommand $command)
    {
        /** @var Student $student */
        $student = $this->repository->get(StudentId::fromString($command->studentId()), 'finance');

        $student->payOffDebts();

        $events = $student->getRecordedEvents();

        $this->repository->add($student);

        foreach($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
