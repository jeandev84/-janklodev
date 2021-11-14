<?php
namespace Jan\Component\Database\Migration;


use Jan\Component\Database\Migration\Support\Migration;
use Jan\Component\Database\Migration\Table\BluePrint;
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
        $this->schema->create($this->getMigrationTable(), function (BluePrint $table) {
            $table->increments('id');
            $table->string('version');
            $table->datetime('executed_at');
        });
    }




    /**
     * @return array
     * @throws \Exception
    */
    public function getAppliedMigrations(): array
    {
        return $this->em->createQueryBuilder()
                        ->select('`version`')
                        ->from($this->migrationTable)
                        ->getQuery()
                        ->getArrayColumns();
    }



    /**
     * @return array
     * @throws \Exception
    */
    public function getToApplyMigrations(): array
    {
        $migrations = [];

        foreach ($this->getMigrations() as $migration) {
            if (! \in_array($migration->getName(), $this->getAppliedMigrations())) {
                $migrations[] = $migration;
            }
        }

        return $migrations;
    }





    /**
     * @return mixed
    */
    public function install()
    {
       $this->createMigrationTable();
    }






    /**
     * @return mixed
    */
    public function diff()
    {
        //
    }




    /**
     * @return mixed
     */
    public function removeMigrations()
    {
        //
    }




    /**
     * @param Migration $migration
     * @return mixed
     */
    public function reverseMigration(Migration $migration)
    {
        //
    }
}