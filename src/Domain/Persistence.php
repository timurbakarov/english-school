<?php

namespace Domain;

interface Persistence
{
    /**
     * @return mixed
     */
    public function all();

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);
}
