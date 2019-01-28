<?php

namespace Domain\Contract;

use Domain\AggregateHistory;

/**
 * An AggregateRoot, that can be reconstituted from an AggregateHistory.
 */
interface IsEventSourced
{
    /**
     * @param AggregateHistory $aggregateHistory
     * @return RecordsEvents|AggregateRoot
     */
    public static function reconstituteFrom(AggregateHistory $aggregateHistory);

    /**
     * @return IdentifiesAggregate
     */
    // @todo do we need this here?
    //public function getAggregateId();
}
