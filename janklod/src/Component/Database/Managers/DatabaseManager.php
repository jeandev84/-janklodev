<?php
namespace Jan\Component\Database\Managers;


use Exception;
use InvalidArgumentException;
use Jan\Component\Database\Connection\Configuration;
use Jan\Component\Database\Connection\ConnectionFactory;
use Jan\Component\Database\Connection\Contract\ConnectionInterface;
use Jan\Component\Database\Connection\Connection;
use Jan\Component\Database\Managers\Contract\DatabaseManagerInterface;
use Jan\Component\Database\Connection\Contract\QueryInterface;
use Jan\Component\Database\Schema\Schema;
use RuntimeException;


/**
 * Class DatabaseManager
 *
 * @package Jan\Component\Database\Managers
*/
class DatabaseManager implements DatabaseManagerInterface
{

    /**
     * @var string
    */
    protected $connection;




    /**
     * @var ConnectionFactory
    */
    protected $factory;




    /**
     * connections storage
     *
     * @var array
    */
    protected $connections = [];






    /**
     * configuration storage
     *
     * @var array
    */
    protected $configs = [];





    /**
     * Collect connection status
     *
     * @var array
    */
    protected $status = [];





    /**
     * DatabaseManager constructor.
    */
    public function __construct(array $params = [])
    {
        if ($params) {
            $this->setConfigurations($params);
        }

        $this->factory = new ConnectionFactory();
    }




    /**
     * Connect to the database
     *
     * (specific : mysql, sqlite, postgres, oracle by default)
     *
     * @param array $config
     * @param string|null $connection
    */
    public function connect(array $config, string $connection)
    {
        if (! $this->connection) {
            $this->setDefaultConnection($connection);
            $this->setConfigurations($config);
        }
    }



    /**
     * @param string $connection
     * @return $this
    */
    public function setDefaultConnection(string $connection): DatabaseManager
    {
        $this->connection = $connection;

        return $this;
    }



    /**
     * @return string
     */
    public function getDefaultConnection(): string
    {
        return $this->connection;
    }




    /**
     * @param string $name
     * @return bool
    */
    public function hasConnection(string $name): bool
    {
        return isset($this->connections[$name]);
    }






    /**
     * @param  string $name
     * @param  mixed $connection
     * @return DatabaseManager
    */
    public function setConnection(string $name, $connection): DatabaseManager
    {
        $this->connections[$name] = $connection;

        return $this;
    }




    /**
     * @param array $connections
     * @return DatabaseManager
    */
    public function setConnections(array $connections): DatabaseManager
    {
        foreach ($connections as $name => $connection) {
            $this->setConnection($name, $connection);
        }

        return $this;
    }




    /**
     * @param array $configs
     * @return $this
    */
    public function setConfigurations(array $configs): DatabaseManager
    {
        foreach ($configs as $name => $params) {
            $this->setConfiguration($name, $params);
        }

        return $this;
    }




    /**
     * @param string $name
     * @param array|string $config
     * @return DatabaseManager
    */
    public function setConfiguration(string $name, $config): DatabaseManager
    {
        $this->configs[$name] = $config;

        return $this;
    }


    /**
     * get connection configuration params
     *
     * @param string $name
     * @return Configuration
     * @throws Exception
    */
    public function configuration(string $name): Configuration
    {
        if (empty($this->configs[$name])) {
            throw new RuntimeException(
                sprintf('empty configuration params for connection to (%s)', $name)
            );
        }

        return new Configuration($this->configs[$name]);
    }



    /**
     * get connection
     *
     * @param string|null $name
     * @return Connection
     * @throws Exception
    */
    public function connection(string $name = null): Connection
    {
        if (! $name) {
            $name = $this->getDefaultConnection();
        }

        $config = $this->configuration($name);

        $this->setDefaultConnection($name);

        if (! $this->hasConnection($name)) {
            return $this->factory->make($name, $config);
        }

        $connection = $this->connections[$name];

        if ($connection instanceof Connection) {
            $connection->connect($config);
        }

        return $connection;
    }




    /**
     * get connection
     *
     * @return Connection
     * @throws Exception
    */
    public function getConnection(): Connection
    {
        return $this->connection();
    }




    /**
     * get configurations
     *
     * @return array
    */
    public function getConfigurations(): array
    {
        return $this->configs;
    }





    /**
     * @param string $name
    */
    public function remove(string $name)
    {
         unset($this->configs[$name], $this->connections[$name]);
    }


    /**
     * @param string|null $name
     * @throws Exception
    */
    public function purge(string $name = null)
    {
        $this->disconnect($name);

        unset($this->connections[$name]);
    }



    /**
     * @param string|null $name
     * @return ConnectionInterface|void
     * @throws Exception
    */
    public function reconnect(string $name = null)
    {
         if (isset($this->connections[$name])) {
             return $this->connection($name);
         }
    }


    /**
     * disconnect connection
     *
     * @param string|null $name
     * @return mixed
     * @throws Exception
    */
    public function disconnect(string $name = null)
    {
        if (isset($this->connections[$name])) {
            return $this->connections[$name]->disconnect();
        }

        if (! $name) {
           return $this->connection()->disconnect();
        }

        throw new InvalidArgumentException('connection ('. $name . ') cannot be disconnected.');
    }




    /**
     * get connections
     *
     * @return array
    */
    public function getConnections(): array
    {
        return $this->connections;
    }




    /**
     * @param $name
     * @param bool $connected
    */
    public function setStatus($name, bool $connected)
    {
        $this->status[$name] = $connected;
    }




    /**
     * @throws Exception
    */
    public function getStatus(string $name): bool
    {
        return $this->status[$name];
    }




    /**
     * @return Configuration
     * @throws Exception
    */
    public function config(): Configuration
    {
        return new Configuration($this->configs);
    }



    /**
     * Flush all setting data
     *
     * @return void
    */
    public function flush()
    {
        $this->configs = [];
        $this->connections = [];
    }



    /**
     * Create database
     *
     * @return void
     * @throws Exception
    */
    public function create()
    {
        $this->exec(sprintf("CREATE DATABASE %s IF NOT EXISTS;", $this->config()->getDatabase()));
    }



    /**
     * @throws Exception
    */
    public function drop()
    {
        $this->exec(sprintf('DROP DATABASE %s IF NOT EXISTS;', $this->config()->getDatabase()));
    }



    /**
     * @param string $sql
     * @param array $params
     * @return QueryInterface
     * @throws Exception
    */
    public function query(string $sql, array $params = []): QueryInterface
    {
        return $this->getConnection()->query($sql, $params);
    }




    /**
     * @throws Exception
    */
    public function exec(string $sql)
    {
        return $this->getConnection()->exec($sql);
    }




    /**
     * Create new class schema table
     *
     * @throws Exception
    */
    public function schema(): Schema
    {
        return new Schema($this);
    }





    /**
     * Backup of database or table
    */
    public function backup() {}





    /**
     * Export database or table
    */
    public function export() {}





    /**
     * Import database or table
    */
    public function import() {}


}

/*
$config = [
    'mysql' => [
        'driver'   => 'mysql',
        'host'     => '127.0.0.1',
        'port'     => '3306',
        'database' => 'mvc',
        'user'     => 'root',
        'pass'     => 'secret'
    ],
    'foo' => [
        'driver'   => 'foo',
        'database' => '../foo.db'
    ]
];


$database = new DatabaseManager();
$database->connect($config, 'mysql');

$database->setConnection('foo', new FooConnection());
$database->setConfiguration('foo', $config['foo']);

dump($database->connection('foo'));
dd($database);
*/