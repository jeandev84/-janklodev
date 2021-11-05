<?php
namespace Jan\Component\Database\Connection\PDO\Connectors;


use Jan\Component\Database\Connection\PDO\PdoConnection;


/**
 * Class OracleConnection
 *
 * @package Jan\Component\Database\Connection\PDO\Connectors
*/
class OracleConnection extends PdoConnection
{

    /**
     * @return string
    */
    public function getName(): string
    {
         return 'oci';
    }
}