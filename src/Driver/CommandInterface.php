<?php

namespace ORM\Driver;

use ORM\Query\QueryInterface;

/**
 *
 */
interface CommandInterface
{
    public function execute(QueryInterface $query);
}
