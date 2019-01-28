<?php

namespace Domain\Contract;

interface CommandBus
{
    /**
     * @param $command
     * @return mixed
     */
    public function dispatch($command);
}
