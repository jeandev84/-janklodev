<?php
namespace Jan\Component\Database\Connection\PDO\Connectors;


use Jan\Component\Database\Connection\PDO\PdoConnection;


/**
 * Class PostgresConnection
 *
 * @package Jan\Component\Database\Connection\PDO\Connectors
*/
class PostgresConnection extends PdoConnection
{

    /**
     * @return string
    */
    public function getName(): string
    {
        return 'postgres'; // pgsql
    }
}