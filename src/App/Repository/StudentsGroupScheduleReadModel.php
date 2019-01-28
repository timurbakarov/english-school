<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

class StudentsGroupScheduleReadModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'group_schedule';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(StudentsGroupReadModel::class, 'group_id', 'id');
    }
}
