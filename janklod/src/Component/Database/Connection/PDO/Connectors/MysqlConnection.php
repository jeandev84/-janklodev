<?php
namespace Jan\Component\Database\Connection\PDO\Connectors;

use Jan\Component\Database\Connection\PDO\PdoConnection;


/**
 * Class MysqlConnection
 *
 * @package Jan\Component\Database\Connection\PDO\Connectors
*/
class MysqlConnection extends PdoConnection
{

    /**
     * @return string
    */
    public function getName(): string
    {
        return 'mysql';
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