<?php

namespace Domain;

class QueryFilter
{
    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @var int
     */
    protected $perPage = 10;

    /**
     * @return int
     */
    public function page()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function perPage()
    {
        return $this->perPage;
    }
}
