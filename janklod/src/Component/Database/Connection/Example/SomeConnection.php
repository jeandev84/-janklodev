<?php
namespace Jan\Component\Database\Connection\Example;

use Jan\Component\Database\Connection\Contract\ConnectionInterface;


class SomeConnection implements ConnectionInterface
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
    public function getDriver()
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
}