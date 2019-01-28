<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StatsByMonthReadModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'stats_by_month';

    /**
     * @var bool
     */
    public $timestamps = false;

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('year', '=', $this->getAttribute('year'))
            ->where('month', '=', $this->getAttribute('month'));
        return $query;
    }
}
