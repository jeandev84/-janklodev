<?php
namespace Jan\Component\Database\Migration\Support;



/**
 * Class MigrationLogger
 *
 * @package Jan\Component\Database\Migration\Support
*/
class MigrationLogger
{

    /**
     * @var array
    */
    protected $migrationLog = [];



    /**
     * @param string $message
    */
    public function log(string $message)
    {
        $this->migrationLog[] = $message;
    }


    /**
     * @return array
    */
    public function getMigrationLog(): array
    {
        return $this->migrationLog;
    }
}