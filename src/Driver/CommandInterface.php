<?php

namespace ORM\Driver;

use ORM\Query\Query;

/**
 *
 */
interface CommandInterface
{
    public function execute(Query $query);
}
