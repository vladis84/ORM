<?php

namespace orm\driver;

use O

interface DriverInterface
{
    public function execute(Query $query) : Response;
}
