<?php
namespace Jan\Component\Database\Migration;


use Exception;
use Jan\Component\Database\Managers\Capsule;
use Jan\Component\Database\Migration\Support\Migration;
use Jan\Component\Database\ORM\EntityManager;
use Jan\Component\Database\Schema\Schema;
use Jan\Component\Database\Schema\BluePrint;
use Jan\Component\Database\Migration\Support\Migrator as BaseMigrator;


/**
 * Class Migrator
 *
 * @package Jan\Component\Database\Migration
*/
class Migrator extends BaseMigrator
{


    /**
     * @return mixed
     */
    public function createMigrationTable()
    {
        // TODO: Implement createMigrationTable() method.
    }

    /**
     * @return array
     */
    public function getAppliedMigrations(): array
    {
        // TODO: Implement getAppliedMigrations() method.
    }

    /**
     * @return array
     */
    public function getToApplyMigrations(): array
    {
        // TODO: Implement getToApplyMigrations() method.
    }

    /**
     * @return mixed
     */
    public function install()
    {
        // TODO: Implement install() method.
    }

    /**
     * @return mixed
     */
    public function diff()
    {
        // TODO: Implement diff() method.
    }

    /**
     * @return mixed
     */
    public function removeMigrations()
    {
        // TODO: Implement removeMigrations() method.
    }

    /**
     * @param Migration $migration
     * @return mixed
     */
    public function reverseMigration(Migration $migration)
    {
        // TODO: Implement reverseMigration() method.
    }
}