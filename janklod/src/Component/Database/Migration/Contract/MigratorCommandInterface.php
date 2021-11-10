<?php
namespace Jan\Component\Database\Migration\Contract;

/**
 * Interface MigratorCommandInterface
 *
 * @package Jan\Component\Database\Migration\Contract
*/
interface MigratorCommandInterface
{
     public function install();
     public function migrate();
     public function rollback();
     public function diff();
     public function reset();
}