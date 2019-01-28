<?php

namespace Domain;

trait EventSourcedTrait
{
    /**
     * @param AggregateHistory $aggregateHistory
     * @return static
     */
    public static function reconstituteFrom(AggregateHistory $aggregateHistory)
    {
        $aggregateId = $aggregateHistory->getAggregateId();

        $aggregate = new static($aggregateId);

        foreach($aggregateHistory as $event) {
            $aggregate->when($event);
        }

        return $aggregate;
    }
}
