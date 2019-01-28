<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseQuery
{
    /**
     * @param Builder $builder
     * @return mixed
     */
    public abstract function build(Builder $builder) : Builder;
}
