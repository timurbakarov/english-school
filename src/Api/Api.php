<?php

namespace Api;

use Illuminate\Contracts\Container\Container;

class Api
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return Students
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function students()
    {
        return $this->container->get(Students::class);
    }

    /**
     * @return StudentsGroups
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function studentsGroups()
    {
        return $this->container->get(StudentsGroups::class);
    }
}
