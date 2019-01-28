<?php

namespace App\Http\Controllers\Student;

use Api\Api;
use Illuminate\Http\Request;
use App\Rules\StudentNameRule;
use Domain\Contract\CommandBus;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Domain\HumanResource\Student\Command\UpdateStudentNameCommand;

class StudentUpdateProfileController
{
    use ValidatesRequests;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Api
     */
    private $api;

    /**
     * @param Request $request
     * @param Api $api
     */
    public function __construct(Request $request, Api $api)
    {
        $this->request = $request;
        $this->api = $api;
    }

    public function __invoke(string $field, string $id)
    {
        $method = 'update' . ucfirst($field);

        if(!method_exists($this, $method)) {
            abort(404);
        }

        $this->$method($id);

        return ['success' => true];
    }

    /**
     * @param string $id
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function updateName(string $id)
    {
        $this->validate($this->request, [
            'name' => [
                'required',
                new StudentNameRule(),
            ],
        ]);

        list($lastName, $firstName) = explode(' ', $this->request->post('name'));

        $this->api->students()->changeName($id, $firstName, $lastName);
    }
}
