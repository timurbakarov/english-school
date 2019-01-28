<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

class StatsByWeekReadModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'stats_by_week';

    /**
     * @var bool
     */
    public $timestamps = false;
}
