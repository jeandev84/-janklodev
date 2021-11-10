<?php
namespace Jan\Component\Database\Migration\Support;

use Jan\Component\Database\Migration\Contract\MigrationCollectionInterface;


/**
 * Class MigrationCollection
 *
 * @package Jan\Component\Database\Migration\Support
*/
class MigrationCollection implements MigrationCollectionInterface
{

    /**
     * @var array
    */
    protected $migrations = [];




    /**
     * @var array
    */
    protected $migrationFiles = [];





    /**
     * @param Migration $migration
     * @return MigrationCollection
    */
    public function addMigration(Migration $migration): MigrationCollection
    {
        $this->migrations[$migration->getName()] = $migration;
        $this->migrationFiles[$migration->getName()] = $migration->getFileName();

        return $this;
    }




    /**
     * @param array $migrations
     * @return $this
    */
    public function setMigrations(array $migrations): MigrationCollection
    {
        foreach ($migrations as $migration) {
            $this->addMigration($migration);
        }

        return $this;
    }





    /**
     * @return array
    */
    public function getMigrations(): array
    {
        return $this->migrations;
    }



    /**
     * @return array
    */
    public function getMigrationFiles(): array
    {
        return $this->migrationFiles;
    }




    /**
     * @return array
    */
    public function getMigrationFilesToRemove(): array
    {
        return array_values($this->migrationFiles);
    }




    /**
     * @param Migration $migration
     * @return bool
    */
    public function exists(Migration $migration): bool
    {
        return \array_key_exists($migration->getName(), $this->migrations);
    }




    /**
     * @param Migration $migration
     * @return mixed
    */
    public function removeMigration(Migration $migration)
    {
          $migrationName = $migration->getName();

          if (! $this->exists($migration)) {
              throw new \RuntimeException('Cannot remove migration : '. $migrationName);
          }

          /** @var Migration $migration */
          $migration = $this->migrations[$migrationName];

          // remove migration from the list
          unset($this->migrations[$migrationName]);

          // remove migration file
          $this->removeMigrationFile($migration);
    }




    /**
     * Remove migration files
     */
    public function removeMigrationFiles()
    {
        /* array_map('unlink', $this->getMigrationFilesToRemove()); */

        foreach ($this->getMigrationFiles() as $migration) {
            $this->removeMigrationFile($migration);
        }
    }



    /**
     * @param Migration $migration
    */
    public function removeMigrationFile(Migration $migration)
    {
        @unlink($migration->getFileName());
        unset($this->migrationFiles[$migration->getName()]);
    }




    /**
     * @return mixed
    */
    public function removeMigrations()
    {
        foreach ($this->migrations as $migration) {
            $this->removeMigration($migration);
        }
    }
}