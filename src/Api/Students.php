<?php

namespace Api;

use Domain\Contract\CommandBus;
use Illuminate\Contracts\Container\Container;
use Domain\HumanResource\Student\Command\AcceptStudentCommand;
use Domain\HumanResource\Student\Command\UpdateStudentNameCommand;

class Students
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
     * @param string $firstName
     * @param string $lastName
     * @param string $groupId
     * @param string|NULL $email
     * @param string $phone
     * @param string $acceptedDate
     * @param string $parents
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function acceptStudent(
        string $firstName,
        string $lastName,
        string $groupId,
        string $email = null,
        string $phone,
        string $acceptedDate,
        string $parents = ''
    ) {
        return $this->container->get(CommandBus::class)->dispatch(new AcceptStudentCommand(
            $firstName,
            $lastName,
            $groupId,
            $email,
            $phone,
            $acceptedDate,
            $parents
        ));
    }

    /**
     * @param string $studentId
     * @param string $firstName
     * @param string $lastName
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function changeName(string $studentId, string $firstName, string $lastName)
    {
        return $this->container->get(CommandBus::class)->dispatch(new UpdateStudentNameCommand(
            $studentId,
            $firstName,
            $lastName
        ));
    }
}
