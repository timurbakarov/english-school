<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

class StudentByGroupAndDateReadModel extends Model
{
    protected $table = 'students_by_group_and_date';

    public $timestamps = false;
}
