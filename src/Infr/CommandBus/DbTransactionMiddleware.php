<?php

namespace Infr\CommandBus;

use Illuminate\Database\Connection;
use League\Tactician\Middleware;

class DbTransactionMiddleware implements Middleware
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param object $command
     * @param callable $next
     * @return mixed
     * @throws \Exception
     */
    public function execute($command, callable $next)
    {
        $this->connection->beginTransaction();

        try {
            $result = $next($command);
        } catch (\Exception $exception) {
            $this->connection->rollBack();

            throw $exception;
        }

        $this->connection->commit();

        return $result;
    }
}
