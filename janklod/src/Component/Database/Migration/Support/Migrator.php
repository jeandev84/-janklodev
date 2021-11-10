<?php
namespace Jan\Component\Database\Migration\Support;


use Exception;
use Jan\Component\Database\Managers\Capsule;
use Jan\Component\Database\Migration\Contract\MigratorInterface;
use Jan\Component\Database\ORM\EntityManager;
use Jan\Component\Database\Schema\Schema;



/**
 * Class Migrator
 *
 * @package Jan\Component\Database\Migration\Support
*/
abstract class Migrator extends MigrationCollection implements MigratorInterface
{


    /**
     * @var string
    */
    protected $migrationTable = 'migrations';




    /**
     * @var Capsule
    */
    protected $db;




    /**
     * @var Schema
    */
    protected $schema;




    /**
     * @var EntityManager
    */
    protected $em;




    /**
     * @param Capsule $db
     * @throws Exception
    */
    public function __construct(Capsule $db)
    {
        $this->db     = $db;
        $this->em     = $db->getEntityManager();
        $this->schema = $db->schema();
    }




    /**
     * Set table name for versions migrations
     *
     * @param string $migrationTable
    */
    public function setMigrationTable(string $migrationTable)
    {
        $this->migrationTable = $migrationTable;
    }




    /**
     * @return string
    */
    public function getMigrationTable(): string
    {
        return $this->migrationTable;
    }




    /**
     * @throws Exception
    */
    public function migrate()
    {
        $this->createMigrationTable();

        $this->upMigrations($this->getToApplyMigrations());
    }





    /**
     * Save migrations to the main table migration.
     *
     * @throws Exception
    */
    public function upMigrations(array $migrations)
    {
        $this->saveMigrations($migrations);
    }




    /**
     * Drop all created tables.
    */
    public function downMigrations(array $migrations)
    {
        foreach ($migrations as $migration) {
             if (method_exists($migration, 'down')) {
                 $this->reverse($migration);
             }
        }
    }



    /**
     * @param Migration $migration
    */
    public function reverse(Migration $migration)
    {
        $migration->down();
    }




    /**
     * @throws Exception
    */
    public function saveMigrations(array $migrations)
    {
        /** @var Migration $migration */
        foreach ($migrations as $migration) {
            $this->saveMigration($migration);
        }
    }




    /**
     * @param Migration $migration
     * @throws Exception
    */
    public function saveMigration(Migration $migration)
    {
         if (method_exists($migration, 'up')) {
              $migration->up();
         }

         $qb = $this->em->createQueryBuilder();

         $qb->insert($migration->getAttributesToSave(), $this->migrationTable)->execute();
    }



    /**
     * @throws Exception
    */
    public function rollback()
    {
        $this->downMigrations($this->migrations);

        $this->schema->truncate($this->migrationTable);
    }




    /**
     * Reset migrations
     *
     * @throws Exception
    */
    public function reset()
    {
        $this->rollback();
        $this->schema->dropIfExists($this->migrationTable);
        $this->removeMigrationFiles();
    }




    public function removeMigrations()
    {
        // TODO: Implement removeMigrations() method.
    }



    /*
    public function unsetMigration(Migration $migration)
    {
        parent::removeMigration($migration);

        $qb = $this->em->createQueryBuilder();

        $qb->delete();
    }
    */



    /**
     * uninstall migration to the migration register
     *
     * @param Migration $migration
     * @return mixed
    */
    abstract public function reverseMigration(Migration $migration);




    /**
     * Create a migration table
     *
     * @throws Exception
    */
    abstract public function createMigrationTable();



    /**
     * @return array
    */
    abstract public function getAppliedMigrations(): array;




    /**
     * @return Migration[]
    */
    abstract public function getToApplyMigrations(): array;

}