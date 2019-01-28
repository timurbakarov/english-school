<?php

namespace Tests\Feature\Scenarios;

use Domain\Date;
use Domain\Education\Lesson;
use Domain\Education\StudentGroup\PricePerHour;
use Domain\Education\StudentGroup\Schedule\GroupClassDuration;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\HumanResource\Student\Event\StudentWasAccepted;
use Domain\Time;
use Domain\LessonId;
use Domain\StudentId;
use Infr\TestServices;
use Domain\DomainEvents;
use Domain\Finance\Student;
use PHPUnit\Framework\TestCase;
use Domain\Finance\Student\PaymentId;
use Domain\Finance\Student\PaymentType;
use Domain\Finance\Student\PaymentAmount;
use Domain\Finance\Student\Event\StudentMadePayment;
use Domain\Finance\Student\Event\StudentPaidOffDebt;
use Domain\Finance\Student\Command\PayOffDebtsCommand;
use Domain\Finance\Student\Command\PayOffDebtsHandler;
use Domain\Finance\Student\Event\StudentGotDebtForLesson;

class _10_StudentPayOffDebtTest extends TestCase
{
    public function test_student_pay_for_lesson()
    {
        $testServices = new TestServices();

        $lessonId = LessonId::generate(Date::fromString('2018-10-11'), new Time(10, 30));
        $studentId = StudentId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            new StudentGotDebtForLesson(
                $studentId,
                $lessonId,
                new PaymentAmount(300),
                Date::fromString('2018-10-11')
            ),
            new StudentGotDebtForLesson(
                $studentId,
                LessonId::generate(Date::fromString('2018-10-12'), new Time(10, 30)),
                new PaymentAmount(500),
                Date::fromString('2018-10-12')
            ),
            new StudentMadePayment(
                $studentId,
                PaymentId::generate(),
                new PaymentAmount(700),
                PaymentType::cash(),
                Date::now()
            )
        ]));

        $command = new PayOffDebtsCommand((string)$studentId);
        $handler = new PayOffDebtsHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentId);

        /** @var StudentPaidOffDebt $event */
        $event = $aggregateHistory[3];

        $this->assertEquals(4, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentPaidOffDebt::class, $event);
        $this->assertEquals((string)$studentId, $event->getAggregateId());
        $this->assertEquals([
            'lesson_id' => (string)$lessonId,
            'amount' => '300',
            'payed_on' => (string)Date::fromString('2018-10-11'),
        ], $event->data());

        /** @var Student $student */
        $student = $testServices->repository()->get($studentId, 'finance');

        $this->assertEquals(400, $student->balance());
    }

    public function test_right_order_of_debts_by_date()
    {
        $testServices = new TestServices();

        $studentId = StudentId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            StudentWasAccepted::forTest($studentId)
        ]));

        /** @var Student $student */
        $student = $testServices->repository()->get($studentId, 'finance');

        $lesson1 = Lesson::give(
            LessonId::generate(Date::fromString('2018-11-12'), new Time(10, 30)),
            StudentGroupId::generate(),
            Date::fromString('2018-11-12'),
            new Time(10, 30),
            new PricePerHour(300),
            new GroupClassDuration(1)
        );

        $lesson2 = Lesson::give(
            LessonId::generate(Date::fromString('2018-10-12'), new Time(10, 30)),
            StudentGroupId::generate(),
            Date::fromString('2018-10-12'),
            new Time(10, 30),
            new PricePerHour(400),
            new GroupClassDuration(1)
        );

        $lesson3 = Lesson::give(
            LessonId::generate(Date::fromString('2018-10-20'), new Time(10, 30)),
            StudentGroupId::generate(),
            Date::fromString('2018-10-20'),
            new Time(10, 30),
            new PricePerHour(500),
            new GroupClassDuration(1)
        );

        $student->payForLesson($lesson1);
        $student->payForLesson($lesson2);
        $student->payForLesson($lesson3);

        $student->makePayment(new PaymentAmount(2000), PaymentType::cash(), Date::now());

        $student->payOffDebts();

        $events = $student->getRecordedEvents();

        /** @var StudentPaidOffDebt $studentPaidOffDebt */
        $studentPaidOffDebt1 = $events[4];
        $studentPaidOffDebt2 = $events[5];
        $studentPaidOffDebt3 = $events[6];

        $this->assertEquals(400, $studentPaidOffDebt1->amount()->value());
        $this->assertEquals(500, $studentPaidOffDebt2->amount()->value());
        $this->assertEquals(300, $studentPaidOffDebt3->amount()->value());
    }
}
