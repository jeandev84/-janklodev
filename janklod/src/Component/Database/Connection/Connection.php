<?php
namespace Jan\Component\Database\Connection;


use Jan\Component\Database\Connection\Contract\ConnectionInterface;
use Jan\Component\Database\Connection\Contract\QueryInterface;


/**
 * Class Connection
 *
 * @package Jan\Component\Database\Connection
*/
abstract class Connection implements ConnectionInterface
{

    /**
     * @var Configuration
    */
    protected $config;



    /**
     * @var
    */
    protected $query;




    /**
     * @var mixed
    */
    protected $driver;




    /**
     * @var bool
    */
    protected $connected = false;




    /**
     * @param $config
    */
    public function connect($config)
    {
         $this->config = $config;
    }




    /**
     * @return Configuration
    */
    public function getConfiguration(): Configuration
    {
        return $this->config;
    }






    /**
     * @param $driver
    */
    public function setDriver($driver)
    {
        $this->driver = $driver;
    }



    /**
     * @return mixed
    */
    public function getDriver()
    {
        return $this->driver;
    }



    /**
     * @throws \Exception
    */
    public function getPdo(): \PDO
    {
         throw new \Exception('unable connection pdo');
    }



    /**
     * Get connection name
     *
     * @return string
     * @throws \Exception
    */
    public function getName(): string
    {
        throw new \Exception('unable connection name.');
    }


    /**
     * @param string $sql
     * @param array $params
     * @param array $options
     * @return QueryInterface
    */
    abstract public function query(string $sql, array $params = [], array $options = []): QueryInterface;




    /**
     * Determine if, has connection.
     *
     * @return bool
    */
    abstract public function connected(): bool;
}