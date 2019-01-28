<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

class StudentsStatsReadModel extends Model
{
    protected $primaryKey = 'student_id';

    /**
     * @var string
     */
    protected $table = 'students_stats';

    public $timestamps = false;
}
