<?php
namespace Jan\Component\Database\Managers;


use Exception;
use Jan\Component\Database\ORM\EntityManager;


/**
 * Class Capsule
 *
 * @package Jan\Component\Database\Managers
*/
class Capsule extends DatabaseManager
{


    /**
     * @var DatabaseManager
    */
    protected static $instance;



    /**
     * @var EntityManager
    */
    protected $em;


    /**
     * @param array $config
     * @param string $connection
     * @return void
    */
    public function addConnection(array $config, string $connection)
    {
        $this->connect($config, $connection);
    }



    /**
     * @return $this
    */
    public function bootAsGlobal(): DatabaseManager
    {
        if (! static::$instance) {
            static::$instance = $this;
        }

        return $this;
    }



    /**
     * @return DatabaseManager
     *
     * @throws Exception
    */
    public static function instance(): DatabaseManager
    {
        if (! static::$instance) {
            throw new Exception('Cannot get instance of capsule.');
        }

        return static::$instance;
    }



    /**
     * @param EntityManager $em
    */
    public function setEntityManager(EntityManager $em)
    {
         $this->em = $em;
    }



    /**
     * @return EntityManager
     * @throws Exception
    */
    public function getEntityManager(): EntityManager
    {
        return $this->em;
    }
}

/*
$fs = new \Jan\Component\FileSystem\FileSystem(
    realpath(__DIR__.'/../')
);
$configDb =  $fs->load('config/database.php');
$capsule = new \Jan\Component\Database\Capsule();
$type = $configDb['connection'];
$capsule->addConnection($configDb, $type);
$capsule->bootAsGlobal();

$database = \Jan\Component\Database\Capsule::instance();
dump($database->connection('sqlite'));
dump($database->connection());
*/