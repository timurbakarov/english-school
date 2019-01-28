<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudentGroupModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'groups';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany(StudentReadModel::class, 'group_id')->orderBy('last_name', 'ASC');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedule()
    {
        return $this->hasMany(StudentsGroupScheduleReadModel::class, 'group_id');
    }
}
