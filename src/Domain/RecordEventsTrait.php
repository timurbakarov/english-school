<?php

namespace Domain;

trait RecordEventsTrait
{
    use When;

    /**
     * @var DomainEvent[]
     */
    private $latestRecordedEvents = [];

    /**
     * @param DomainEvent $domainEvent
     */
    protected function recordThat(DomainEvent $domainEvent)
    {
        $this->latestRecordedEvents[] = $domainEvent;

        $domainEvent->markCreatedAt();

        $this->when($domainEvent);
    }


    /**
     * Get all the Domain Events that were recorded since the last time it was cleared, or since it was
     * restored from persistence. This does not include events that were recorded prior.
     * @return DomainEvents
     */
    public function getRecordedEvents()
    {
        return new DomainEvents($this->latestRecordedEvents);
    }

    /**
     * Clears the record of new Domain Events. This doesn't clear the history of the object.
     * @return void
     */
    public function clearRecordedEvents()
    {
        $this->latestRecordedEvents = [];
    }
}
