<?php

namespace ORM;

/**
 *
 */
class ORM
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * @var \ORM\Driver\DB\DriverInterface
     */
    public $db;

    /**
     * @var \ORM\Record\Repository
     */
    public $recordRepository;


    private function __construct()
    {
    }

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return static::$instance;
    }

    public function run(array $customConfig = [])
    {
        $baseConfig = require __DIR__ . '/../config.php';

        $config = array_merge_recursive($baseConfig, $customConfig);

        $db = new $config['db']['class'];
        foreach ($config['db'] as $property => $value) {
            if (property_exists($db, $property)) {
                $db->$property = $value;
            }
        }
        $this->db = $db;

        $this->recordRepository = new \ORM\Record\Repository();
    }
}
