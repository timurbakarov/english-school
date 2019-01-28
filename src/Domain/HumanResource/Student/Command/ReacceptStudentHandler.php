<?php

namespace Domain\HumanResource\Student\Command;

use Domain\Date;
use Domain\StudentId;
use Domain\HumanResource\Student;
use Infr\Repository\GeneralRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Domain\Education\StudentGroup\StudentGroupId;

class ReacceptStudentHandler
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

    public function handle(ReacceptStudentCommand $command)
    {
        /** @var Student $student */
        $student = $this->repository->get(StudentId::fromString($command->studentId()), 'human_resource');

        $student->reaccept(StudentGroupId::fromString($command->studentGroupId()), Date::fromString($command->reacceptOn()));

        $events = $student->getRecordedEvents();

        $this->repository->add($student);

        foreach($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
