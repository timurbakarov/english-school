<?php

namespace Domain\Education\Lesson\Command;

use Domain\HumanResource\Student;
use Domain\LessonId;
use Domain\StudentId;
use Domain\Education\Lesson;
use Infr\Repository\GeneralRepository;
use Illuminate\Contracts\Events\Dispatcher;

class MarkStudentLessonStatusHandler
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
     * @param MarkStudentLessonStatusCommand $command
     * @throws Lesson\Exception\StudentWasAlreadyMarkedException
     * @throws Student\Exception\StudentIsDismissedException
     * @throws \Domain\Exception\AggregateDoesNotExistException
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public function handle(MarkStudentLessonStatusCommand $command)
    {
        /** @var Student $student */
        $student = $this->repository->get(StudentId::fromString($command->studentId()), 'human_resource');

        /** @var Lesson $lesson */
        $lesson = $this->repository->get(LessonId::fromString($command->lessonId()));

        $lesson->markStudentLessonStatus($student, $command->status());

        $events = $lesson->getRecordedEvents();

        $this->repository->add($lesson);

        foreach($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
