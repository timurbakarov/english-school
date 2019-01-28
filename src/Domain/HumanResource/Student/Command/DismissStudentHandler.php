<?php

namespace Domain\HumanResource\Student\Command;

use Domain\Date;
use Domain\HumanResource\Student;
use Infr\Repository\GeneralRepository;
use Domain\StudentId;
use Illuminate\Contracts\Events\Dispatcher;

class DismissStudentHandler
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

    public function handle(DismissStudentCommand $command)
    {
        /** @var Student $student */
        $student = $this->repository->get(StudentId::fromString($command->studentId()), 'human_resource');

        $student->dismiss($command->reason(), Date::fromString($command->dismissedOn()));

        $events = $student->getRecordedEvents();

        $this->repository->add($student);

        foreach($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
