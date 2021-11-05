<?php
namespace Jan\Component\Database\Connection;


use InvalidArgumentException;
use Jan\Component\Database\Connection\PDO\Connectors\MysqlConnection;
use Jan\Component\Database\Connection\PDO\Connectors\OracleConnection;
use Jan\Component\Database\Connection\PDO\Connectors\PostgresConnection;
use Jan\Component\Database\Connection\PDO\Connectors\SqliteConnection;


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
          switch ($name) {
              case 'mysql':
                  $connection = new MysqlConnection();
                  break;
              case 'pgsql':
                  $connection = new PostgresConnection();
                  break;
              case 'sqlite':
                  $connection = new SqliteConnection();
                  break;
              case 'oci':
                  $connection = new OracleConnection();
              break;
              default:
                  throw new InvalidArgumentException('Unsupported driver ('. $name .')');

          }

          $connection->connect($config);

          return $connection;
    }
}