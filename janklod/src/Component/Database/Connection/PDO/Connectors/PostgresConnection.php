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


    /**
     * @return string[]
    */
    public function getDefaultOptions(): array
    {
        return [
            'commands' => 'SET SQL_MODE=ANSI_QUOTES'
        ];
    }
}