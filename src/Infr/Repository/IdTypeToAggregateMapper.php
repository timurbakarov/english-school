<?php

namespace Infr\Repository;

use Domain\Exception\InvalidArgumentException;

class IdTypeToAggregateMapper implements RepositoryMapper
{
    /**
     * @var array
     */
    private $map;

    /**
     * @param array $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * @param $id
     * @param string|null $context
     * @return string
     * @throws \Exception
     */
    public function map($id, string $context = null): string
    {
        $idClassName = get_class($id);

        if(!isset($this->map[$idClassName])) {
            throw new \Exception("Invalid id class");
        }

        if(is_array($this->map[$idClassName]) AND !$context) {
            $contexts = array_keys($this->map[$idClassName]);

            throw new InvalidArgumentException(sprintf("Need context to load. Available contexts: %s", implode(', ', $contexts)));
        }

        if($context AND !isset($this->map[$idClassName][$context])) {
            throw new InvalidArgumentException(sprintf('Context [%s] does not exist', $context));
        }

        return $context ? $this->map[$idClassName][$context] : $this->map[$idClassName];
    }
}
