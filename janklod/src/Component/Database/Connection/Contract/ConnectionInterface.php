<?php
namespace Jan\Component\Database\Connection\Contract;


use Jan\Component\Database\Connection\PdoConfiguration;


/**
 * Interface ConnectionInterface
 *
 * @package Jan\Component\Database\Connection\Contract
*/
interface ConnectionInterface
{

   /**
     * open connection
     *
     * @param array|PdoConfiguration $config
     * @return mixed
   */
   public function connect($config);





   /**
     * @return string
   */
   public function getName(): string;




   /**
    * Get connection driver example PDO(), mysqli() ...
    *
    * @return mixed
   */
   public function getDriverConnection();




   /**
     * @return bool
   */
   public function connected(): bool;




   /**
     * close connection
     *
     * @return mixed
   */
   public function disconnect();




   /**
     * @param string $sql
     * @param array $params
     * @return mixed
   */
   public function query(string $sql, array $params = []);




   /**
     * @param string $sql
     * @return mixed
   */
   public function exec(string $sql);
}