<?php
namespace Jan\Component\Database\Connection\Example;

use Jan\Component\Database\Connection\Connection;
use Jan\Component\Database\Connection\Contract\ConnectionInterface;


class FooConnection extends Connection
{

    /**
     * @param array $config
     * @return mixed
     */
    public function connect(array $config)
    {
        // TODO: Implement connect() method.
    }

    /**
     * @return mixed
     */
    public function getDriverConnection()
    {
        // TODO: Implement getConnection() method.
    }

    /**
     * @return mixed
     */
    public function disconnect()
    {
        // TODO: Implement disconnect() method.
    }

    public function query(string $sql, array $params = [])
    {
        // TODO: Implement query() method.
    }
}