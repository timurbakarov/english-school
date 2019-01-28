<?php

namespace Infr\CommandBus;

use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Exception\MissingHandlerException;

class SameFolderLocator implements HandlerLocator
{
    /**
     * Retrieves the handler for a specified command
     *
     * @param string $commandName
     *
     * @return object
     *
     * @throws MissingHandlerException
     */
    public function getHandlerForCommand($commandName)
    {
        $commandClassNameSegments = explode('\\', $commandName);

        $totalSegments = count($commandClassNameSegments);

        $handlerClassName = str_replace('Command', 'Handler', $commandClassNameSegments[$totalSegments - 1]);

        $commandClassNameSegments[$totalSegments - 1] = $handlerClassName;

        $handlerFullName = implode('\\', $commandClassNameSegments);

        return app()->make($handlerFullName);
    }
}
