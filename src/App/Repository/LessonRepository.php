<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

class LessonRepository extends Model
{
    protected $table = 'lessons';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function student()
    {
        return $this->hasOne(StudentRepository::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function group()
    {
        return $this->hasOne(GroupsRepository::class, 'group_id');
    }
}
