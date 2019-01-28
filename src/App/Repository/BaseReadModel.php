<?php

namespace App\Repository;

use App\BaseQuery;
use Illuminate\Database\Eloquent\Model;

class BaseReadModel extends Model
{
    /**
     * @param BaseQuery $query
     * @return mixed
     */
    public function withQuery(BaseQuery $query)
    {
        return $query->build($this->newQuery());
    }
}
