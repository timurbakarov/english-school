<?php

namespace App\Repository;

class StudentReadModel extends BaseReadModel
{
    /**
     * @var string
     */
    protected $table = 'students';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function group()
    {
        return $this->hasOne(StudentsGroupReadModel::class, 'id', 'group_id');
    }


}
