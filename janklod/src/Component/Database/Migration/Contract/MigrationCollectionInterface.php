<?php
namespace Jan\Component\Database\Migration\Contract;


use Jan\Component\Database\Migration\Support\Migration;



/**
 * Interface MigrationCollectionInterface
 *
 * @package Jan\Component\Database\Migration\Contract
*/
interface MigrationCollectionInterface
{
    public function addMigration(Migration $migration);

    public function removeMigration(Migration $migration);

    public function getMigrations();

    public function removeMigrations();
}