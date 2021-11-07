<?php
namespace Jan\Component\Database\Connection;


use InvalidArgumentException;
use Jan\Component\Database\Connection\PDO\Connectors\MysqlConnection;
use Jan\Component\Database\Connection\PDO\Connectors\OracleConnection;
use Jan\Component\Database\Connection\PDO\Connectors\PostgresConnection;
use Jan\Component\Database\Connection\PDO\Connectors\SqliteConnection;
use Jan\Component\Database\Connection\PDO\PdoConfiguration;


/**
 * Class ConnectionFactory
 *
 * @package Jan\Component\Database\Connection
*/
class ConnectionFactory
{

    /**
     * @param string $name
     * @param mixed $config
     * @return Connection|null
     * @throws \Exception
    */
    public function make(string $name, $config): ?Connection
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

          return $connection;
    }
}