<?php

spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'ORM\\';

    // base directory for the namespace prefix
    $base_dir = __DIR__ . '/../src/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

class User extends ORM\Record
{
    public static $pk = 'id';

    public static $fieldsMap = [
        'id' => 'id',
        'lastName' => 'last_name',
    ];

    public $id;

    /**
     * asdas
     * @var string
     */
    public $lastName;
}

class UserRepository extends \ORM\Repository
{
    protected $recordClassName = User::class;

    public function findUserByLastName($lastName)
    {
        $sql = "SELECT id FROM user WHERE last_name LIKE :lastName";
        $response = $this->query($sql, ['lastName' => $lastName]);

        $value = $response->one();
        
        $record = $this->recordClassName::getInstance($value['id']);

        return $record;
    }
}

$config = [
    'db' => [
        'class'    => \ORM\Driver\DB\PDO::class,
        'dsn'      => 'mysql:dbname=orm;host=127.0.0.1',
        'user'     => 'root',
        'password' => '1234567',
    ]
];

\ORM\ORM::getInstance()->run($config);

$userRepository = new UserRepository;
$userRepository->findUserByLastName('Петрова5');