<?php

namespace Api;

use Domain\Contract\CommandBus;
use Illuminate\Contracts\Container\Container;
use Domain\Education\StudentGroup\Command\CreateStudentGroupCommand;

class StudentsGroups
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
     * @param string $name
     * @param string $schedule
     * @param int $pricePerHour
     * @param string $createdDate
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function createGroup(string $name, string $schedule, int $pricePerHour, string $createdDate)
    {
        return $this->container->get(CommandBus::class)->dispatch(new CreateStudentGroupCommand(
            $name, $schedule, $pricePerHour, $createdDate
        ));
    }
}
