<?php
namespace Jan\Component\Database\Schema;


use Closure;
use Exception;
use Jan\Component\Database\Connection\Configuration;
use Jan\Component\Database\Managers\DatabaseManager;
use Jan\Component\Database\ORM\EntityManager;
use Jan\Component\Database\ORM\Contract\EntityManagerInterface;



/**
 * Class Schema
 *
 * @package Jan\Component\Database\Schema
*/
class Schema
{

   /**
    * @var DatabaseManager
   */
   protected $db;



   /**
    * @var Configuration
   */
   protected $config;


    /**
     * Database constructor
     *
     * @param DatabaseManager $db
     * @throws Exception
    */
   public function __construct(DatabaseManager $db)
   {
        $this->db     = $db;
        $this->config = $db->config();
   }




   /**
    * @param string $table
    * @param Closure $closure
    * @throws Exception
   */
   public function create(string $table, Closure $closure)
   {
        $tableName = $this->db->config()->prefixTable($table);
        $bluePrint = new BluePrint($tableName);
        $closure($bluePrint);

        $this->createTable($tableName, $bluePrint);
   }




   /**
     * @param string $table
     * @throws Exception
     * @throws Exception
   */
   public function drop(string $table)
   {
       $this->db->exec(sprintf('DROP TABLE `%s`;', $table));
   }




   /**
     * @param string $table
     * @return void
     * @throws Exception
     * @throws Exception
   */
   public function dropIfExists(string $table)
   {
       $this->db->exec(sprintf('DROP TABLE IF EXISTS `%s`;', $table));
   }




    /**
     * @param string $table
     * @param BluePrint $bluePrint
     * @throws Exception
    */
    public function createTable(string $table, BluePrint $bluePrint)
    {
        $sql = sprintf("CREATE TABLE IF NOT EXISTS `%s` (%s) ENGINE=%s DEFAULT CHARSET=%s;",
            $table,
            $bluePrint->getConstraintColumns(),
            $this->config->getEngine(),
            $this->config->getCharset()
        );

        // dd($sql);
        $this->db->exec($sql);
    }



    /**
     * @param string $table
     * @throws Exception
     */
    public function truncate(string $table)
    {
        $this->db->exec(sprintf('TRUNCATE TABLE %s;', $table));
    }



    /**
     * @param string $table
    */
    public function truncateCascade(string $table) {}

}


/*
Schema::create('users', function (BluePrint $table) {
    $table->increments('id');
    $table->string('username');
    $table->string('password');
    $table->string('role');
});


$capsule = \Jan\Component\Database\Capsule::instance();

$schema = $capsule->schema();

$schema->create('pages', function (\Jan\Component\Database\Schema\BluePrint $table) {
    $table->increments('id');
    $table->string('title', '200');
    $table->text('content');
    $table->timestamps();
});
*/