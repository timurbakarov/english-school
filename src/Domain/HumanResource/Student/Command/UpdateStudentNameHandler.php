<?php

namespace Domain\HumanResource\Student\Command;

use Domain\StudentId;
use Domain\HumanResource\Student;
use Infr\Repository\GeneralRepository;
use Illuminate\Contracts\Events\Dispatcher;

class UpdateStudentNameHandler
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

    public function handle(UpdateStudentNameCommand $command)
    {
        /** @var Student $student */
        $student = $this->repository->get(StudentId::fromString($command->studentId()), 'human_resource');

        if($command->firstName() && $command->lastName()) {
            $name = new Student\Name($command->firstName(), $command->lastName());
        } else {
            $name = null;
        }

        $student->updateName($name);

        $events = $student->getRecordedEvents();

        if($events->count()) {
            $this->repository->add($student);

            foreach($events as $event) {
                $this->eventDispatcher->dispatch($event);
            }
        }
    }
}
