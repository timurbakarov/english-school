<?php

namespace Tests\Feature\Scenarios;

use Domain\Education\Lesson\Event\StudentAttendedLesson;
use Domain\Education\Lesson\Event\StudentAttendedLessonWasUnmarked;
use Domain\LessonId;
use Domain\StudentId;
use Infr\TestServices;
use Domain\DomainEvents;
use PHPUnit\Framework\TestCase;
use Domain\Education\Lesson\Event\LessonWasGiven;
use Domain\Education\Lesson\Event\StudentMissedLesson;
use Domain\HumanResource\Student\Event\StudentWasAccepted;
use Domain\Education\Lesson\Event\StudentMissedLessonWasUnmarked;
use Domain\Education\Lesson\Command\UnmarkStudentLessonStatusCommand;
use Domain\Education\Lesson\Command\UnmarkStudentLessonStatusHandler;

class _12_UnmarkStudentLessonStatusScenarioTest extends TestCase
{
    public function test_throw_exception_if_lesson_does_not_have_student()
    {
        $this->expectExceptionMessage('Student does not exist in this lesson');

        $testServices = new TestServices();

        $lessonId = LessonId::generate();
        $studentId = StudentId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            StudentWasAccepted::forTest($studentId),
            LessonWasGiven::forTest($lessonId),
            new StudentMissedLesson($lessonId, $studentId)
        ]));

        $command = new UnmarkStudentLessonStatusCommand((string)$lessonId, StudentId::generate());
        $handler = new UnmarkStudentLessonStatusHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $handler->handle($command);
    }

    public function test_student_unmark_student_miss_lesson()
    {
        $testServices = new TestServices();

        $lessonId = LessonId::generate();
        $studentId = StudentId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            StudentWasAccepted::forTest($studentId),
            LessonWasGiven::forTest($lessonId),
            new StudentMissedLesson($lessonId, $studentId)
        ]));

        $command = new UnmarkStudentLessonStatusCommand((string)$lessonId, (string)$studentId);
        $handler = new UnmarkStudentLessonStatusHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($lessonId);

        /** @var StudentMissedLessonWasUnmarked $event */
        $event = $aggregateHistory[2];

        $this->assertEquals(3, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentMissedLessonWasUnmarked::class, $event);
        $this->assertEquals((string)$lessonId, $event->getAggregateId());
        $this->assertEquals([
            'student_id' => (string)$studentId,
        ], $event->data());
    }

    public function test_student_unmark_student_attend_lesson()
    {
        $testServices = new TestServices();

        $lessonId = LessonId::generate();
        $studentId = StudentId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            StudentWasAccepted::forTest($studentId),
            LessonWasGiven::forTest($lessonId),
            new StudentAttendedLesson($lessonId, $studentId)
        ]));

        $command = new UnmarkStudentLessonStatusCommand((string)$lessonId, (string)$studentId);
        $handler = new UnmarkStudentLessonStatusHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($lessonId);

        /** @var StudentAttendedLessonWasUnmarked $event */
        $event = $aggregateHistory[2];

        $this->assertEquals(3, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentAttendedLessonWasUnmarked::class, $event);
        $this->assertEquals((string)$lessonId, $event->getAggregateId());
        $this->assertEquals([
            'student_id' => (string)$studentId,
        ], $event->data());
    }
}
