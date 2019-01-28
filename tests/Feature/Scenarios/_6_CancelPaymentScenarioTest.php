<?php

namespace Tests\Feature\Scenarios;

use Domain\Date;
use Domain\StudentId;
use Infr\TestServices;
use Domain\DomainEvents;
use PHPUnit\Framework\TestCase;
use Domain\Finance\Student\PaymentId;
use Domain\Finance\Student\PaymentType;
use Domain\Finance\Student\PaymentAmount;
use Domain\Finance\Student\Event\StudentMadePayment;
use Domain\Finance\Student\Event\PaymentWasCancelled;
use Domain\Finance\Student\Command\CancelPaymentCommand;
use Domain\Finance\Student\Command\CancelPaymentHandler;

class _6_CancelPaymentScenarioTest extends TestCase
{
    public function test_make_payment()
    {
        $testServices = new TestServices();

        $studentId = StudentId::generate();
        $paymentId = PaymentId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            new StudentMadePayment(
                $studentId,
                $paymentId,
                new PaymentAmount(500),
                PaymentType::cash(),
                Date::fromString('2018-10-12')
            )
        ]));

        $command = new CancelPaymentCommand($studentId, $paymentId, 'Comment');
        $handler = new CancelPaymentHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentId);

        /** @var PaymentWasCancelled $event */
        $event = $aggregateHistory[1];

        $this->assertEquals(2, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(PaymentWasCancelled::class, $event);
        $this->assertEquals($studentId->toString(), $event->getAggregateId());
        $this->assertEquals([
            'payment_id' => (string)$paymentId,
            'amount' => '500',
            'comment' => 'Comment',
            'cancelled_on' => (string)Date::now(),
            'payed_on' => '2018-10-12',
        ], $event->data());
    }
}
