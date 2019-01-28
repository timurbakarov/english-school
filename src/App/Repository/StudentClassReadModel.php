<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

class StudentClassReadModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'students_classes';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function studyClass()
    {
        return $this->hasOne(StudyClassReadModel::class, 'study_class_id', 'study_class_id');
    }
}
