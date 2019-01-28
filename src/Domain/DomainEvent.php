<?php

namespace Domain;

abstract class DomainEvent implements \Domain\Contract\DomainEvent
{
    /**
     * @var
     */
    protected $createdAt;

    /**
     * @return $this
     */
    public function markCreatedAt()
    {
        $this->createdAt = microtime(true);

        return $this;
    }

    /**
     * @return mixed
     */
    public function createdAt()
    {
        return $this->createdAt;
    }
}
