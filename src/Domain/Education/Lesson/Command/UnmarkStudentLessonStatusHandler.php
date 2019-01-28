<?php

namespace Domain\Education\Lesson\Command;

use Domain\LessonId;
use Domain\StudentId;
use Domain\Education\Lesson;
use Infr\Repository\GeneralRepository;
use Illuminate\Contracts\Events\Dispatcher;

class UnmarkStudentLessonStatusHandler
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

    public function handle(UnmarkStudentLessonStatusCommand $command)
    {
        /** @var Lesson $lesson */
        $lesson = $this->repository->get(LessonId::fromString($command->lessonId()));

        $lesson->unmarkStudentLessonStatus(StudentId::fromString($command->studentId()));

        $events = $lesson->getRecordedEvents();

        $this->repository->add($lesson);

        foreach($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
