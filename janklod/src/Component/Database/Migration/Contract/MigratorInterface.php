<?php
namespace Jan\Component\Database\Migration\Contract;


use Jan\Component\Database\Migration\Support\Migration;

/**
 * Interface MigratorInterface
 *
 * @package Jan\Component\Database\Migration\Contract
*/
interface MigratorInterface extends MigratorCommandInterface
{
     public function getMigrationTable();
     public function getAppliedMigrations(): array;
     public function getToApplyMigrations(): array;
     public function saveMigration(Migration $migration);
     public function reverseMigration(Migration $migration);
}