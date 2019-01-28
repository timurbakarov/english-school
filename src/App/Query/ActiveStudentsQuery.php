<?php

namespace App\Query;

use App\BaseQuery;
use App\TableFilter\StudentsTableFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ActiveStudentsQuery extends BaseQuery
{
    /**
     * @var StudentsTableFilter
     */
    private $filter;

    /**
     * ActiveStudentsQuery constructor.
     * @param StudentsTableFilter $filter
     */
    public function __construct(StudentsTableFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @param Builder $builder
     * @return mixed
     */
    public function build(Builder $builder) : Builder
    {
        $builder->where('is_active', $this->filter->active());

        return $builder;
    }
}
