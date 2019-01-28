<?php

namespace Domain\Contract;

use Domain\DomainEvents;
use Domain\AggregateHistory;

interface EventStore
{
    /**
     * @param DomainEvents $events
     * @return void
     */
    public function commit(DomainEvents $events);

    /**
     * @param IdentifiesAggregate $id
     * @return AggregateHistory
     */
    public function getAggregateHistoryFor(IdentifiesAggregate $id);

    /**
     * @param array $event
     * @return mixed
     */
    public function byEvents(array $event);
}
