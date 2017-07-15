<?php

namespace ORM;

/**
 * 
 */
class Repository
{
    /**
     * @var string
     */
    protected $recordClassName;

    /**
     * @param string $sql
     * @param array $params
     * @return Driver\DB\ResponseInterface
     */
    protected function query($sql, array $params)
    {
        return \ORM\ORM::getInstance()->db->execute($sql, $params);
    }
}
