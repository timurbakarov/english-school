<?php

namespace Domain\Contract;

/**
 * Something that happened in the past, that is of importance to the business.
 */
interface DomainEvent
{
    /**
     * The Aggregate this event belongs to.
     * @return IdentifiesAggregate
     */
    public function getAggregateId();

    /**
     * @return mixed
     */
    public function data() : array;

    /**
     * @param $data
     * @return DomainEvent
     */
    public static function rebuildFromData($data) : DomainEvent;
}
