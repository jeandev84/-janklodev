<?php
namespace Jan\Component\Database\Connection;


use InvalidArgumentException;
use Jan\Component\Database\Connection\PDO\Connectors\MysqlConnection;
use Jan\Component\Database\Connection\PDO\Connectors\OracleConnection;
use Jan\Component\Database\Connection\PDO\Connectors\PostgresConnection;
use Jan\Component\Database\Connection\PDO\Connectors\SqliteConnection;
use Jan\Component\Database\Connection\PDO\PdoConfiguration;
use Jan\Component\Database\Connection\PDO\PdoConnection;


/**
 * Class ConnectionFactory
 *
 * @package Jan\Component\Database\Connection
*/
class ConnectionFactory
{


    /**
     * @var PdoConnection
    */
    protected $pdoConnection;




    /**
     * @var string
    */
    protected $type;




    /**
     * @param string $type
    */
    public function __construct(string $type = 'pdo_drivers')
    {
          $this->type = $type;
    }





    /**
     * @param string $name
     * @param array $config
     * @return Connection|null
     * @throws \Exception
    */
    public function make(string $name, array $config): ?Connection
    {
          switch ($this->type) {
              case 'pdo_drivers':
                    $connection = $this->makePdoConnection($name, $config);
                  break;
              default:
                  throw new \Exception('Type ('. $this->type .') no match connection type drivers.');
          }

          return $connection;
    }




    /**
     * @return PdoConnection
    */
    public function getPdoConnection(): PdoConnection
    {
        return $this->pdoConnection;
    }



    /**
     * @param string $name
     * @param array $config
     * @return MysqlConnection|OracleConnection|PostgresConnection|SqliteConnection
     * @throws \Exception
    */
    protected function makePdoConnection(string $name, array $config)
    {
        $pdoConfiguration = new PdoConfiguration($config);

        switch ($name) {
            case 'mysql':
                $connection = new MysqlConnection($pdoConfiguration);
                break;
            case 'pgsql':
                $connection = new PostgresConnection($pdoConfiguration);
                break;
            case 'sqlite':
                $connection = new SqliteConnection($pdoConfiguration);
                break;
            case 'oci':
                $connection = new OracleConnection($pdoConfiguration);
                break;
            default:
                throw new InvalidArgumentException('Unsupported driver ('. $name .')');

        }

        $connection->connect($config);

        return $this->pdoConnection = $connection;
    }
}