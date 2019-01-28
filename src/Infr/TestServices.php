<?php

namespace Infr;

use Infr\Event\DummyEventDispatcher;
use Infr\Repository\GeneralRepository;
use Infr\EventStore\InMemoryEventStore;
use Infr\Repository\IdTypeToAggregateMapper;

class TestServices
{
    /**
     * @var DummyEventDispatcher
     */
    private $eventDispatcher;

    /**
     * @var InMemoryEventStore
     */
    private $eventStore;

    /**
     * @var GeneralRepository
     */
    private $repository;

    /**
     * @var IdTypeToAggregateMapper
     */
    private $repositoryMapper;

    public function __construct()
    {
        $repositoryConfig = include __DIR__ . '/../../config/repository.php';

        $this->eventDispatcher = new DummyEventDispatcher();
        $this->eventStore = new InMemoryEventStore();
        $this->repositoryMapper = new IdTypeToAggregateMapper($repositoryConfig['map']);
        $this->repository = new GeneralRepository($this->eventStore, $this->repositoryMapper);
    }

    /**
     * @return DummyEventDispatcher
     */
    public function eventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @return InMemoryEventStore
     */
    public function eventStore()
    {
        return $this->eventStore;
    }

    /**
     * @return GeneralRepository
     */
    public function repository()
    {
        return $this->repository;
    }
}
