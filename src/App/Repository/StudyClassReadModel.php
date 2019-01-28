<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

class StudyClassReadModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'study_classes';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string
     */
    protected $primaryKey = 'study_class_id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function group()
    {
        return $this->hasOne(StudentsGroupReadModel::class, 'id', 'group_id');
    }
}
