<?php

namespace Infr\Repository;

interface RepositoryMapper
{
    /**
     * @param $id
     * @param string|null $context
     * @return string
     */
    public function map($id, string $context = null) : string;
}
