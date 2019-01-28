<?php

namespace Infr\CommandBus;

use League\Tactician\CommandBus;

class TacticianCommandBusAdapter extends CommandBus implements \Domain\Contract\CommandBus
{
    /**
     * @param $command
     * @return mixed
     */
    public function dispatch($command)
    {
        return $this->handle($command);
    }
}
