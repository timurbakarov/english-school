<?php

namespace App\TableFilter;

use Illuminate\Http\Request;

class StudentsTableFilter
{
    /**
     * @var Request
     */
    private $request;

    /**
     * StudentsTableFilter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return array|null|string
     */
    public function active()
    {
        return $this->request->query('active', 1);
    }
}
