<?php
namespace Jan\Foundation\Provider;

use Jan\Component\Config\Config;
use Jan\Component\Container\ServiceProvider\Contract\BootableServiceProvider;
use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Component\Database\Managers\Capsule;
use Jan\Component\Database\ORM\EntityManager;
use Jan\Component\Database\ORM\ManagerRegistry;
use Jan\Component\Database\Connection\PDO\PdoConnection;
use Jan\Component\Database\ORM\Contract\EntityManagerInterface;
use Jan\Component\Database\ORM\Contract\ManagerRegistryInterface;
use Jan\Component\Database\Migration\Migrator;
use Jan\Component\FileSystem\FileSystem;


/**
 * Class DatabaseServiceProvider
 *
 * @package Jan\Foundation\Provider
*/
class DatabaseServiceProvider extends ServiceProvider implements BootableServiceProvider
{


    public function boot()
    {
        // TODO: Implement boot() method.
    }



    /**
     * @return void
     * @throws \Exception
    */
    public function register()
    {
        // capsule manager
        $this->registryCapsule();

        // migrator manager
        $this->registryMigrationProcess();

        // entity manager
        $this->registryEntityManager();

        // registry manager
        $this->registryManagerRegistry();
    }




    /**
     * Boot capsule manager
    */
    protected function registryCapsule()
    {
        $this->app->singleton('capsule', function (Config $config) {
            $capsule = new Capsule();
            $capsule->addConnection($config['database'], $config['database']['connection']);
            $capsule->bootAsGlobal();

            /** @var PdoConnection $connection */
            $connection = $capsule->getConnection();

            $em = new EntityManager($connection);

            $capsule->setEntityManager($em);

            return $capsule;
        });
    }


    
    /**
     * Boot entity Manager
    */
    protected function registryEntityManager()
    {
        $this->app->singleton(EntityManager::class, function () {
            return $this->app->get('capsule')->getEntityManager();
        });

        $this->app->singleton(EntityManagerInterface::class, function () {
            return $this->app->get(EntityManager::class);
        });
    }



    /**
     * Boot manager registry
    */
    protected function registryManagerRegistry()
    {
        $this->app->singleton(ManagerRegistryInterface::class, function () {

            $registry = new ManagerRegistry();
            $registry->setEntityManager($this->app->get(EntityManager::class));

            return $registry;
        });
    }



    /**
     * Boot migrator
    */
    protected function registryMigrationProcess()
    {
         $this->app->singleton(Migrator::class, function (FileSystem $fs) {

             $capsule = $this->app->get('capsule');
             $migrator = new Migrator($capsule);
             $migrator->migrationTable('capsule_migrations');

             $migrator->addMigrations($this->loadMigrations($fs));

             return $migrator;
         });


         $this->app->singleton('capsule.schema', function () {
             return $this->app->get('capsule')->schema();
         });
    }



    /**
     * @param FileSystem $fs
     * @return array
     * @throws \Exception
    */
    protected function loadMigrations(FileSystem $fs): array
    {
         $files = $fs->resources('app/Migration/*.php');

         $migrations = [];

         foreach ($files as $file) {
             $migrationClass = $fs->info($file)->getFilename();
             $migrationClass = sprintf('App\\Migration\\%s', $migrationClass);
             $migration = $this->app->get($migrationClass);
             $migrations[] = $migration;
         }

         return $migrations;
    }


    /**
     * @param Config $config
     * @return Capsule
     * @throws \Exception
    */
    protected function createCapsuleConnection(Config $config): Capsule
    {
        $capsule = new Capsule();
        $capsule->addConnection($config['database'], $config['database']['connection']);
        $capsule->bootAsGlobal();

        /** @var PdoConnection $connection */
        $connection = $capsule->getConnection();

        $em = new EntityManager($connection);

        $capsule->setEntityManager($em);

        return $capsule;
    }




    /*
    protected function getMigrations(FileSystem $fs)
    {
        $migrationFiles = $fs->loadResources('migrations/*.php');

        foreach ($migrationFiles as $migrationFile) {
            $time     = (new \DateTime())->format('Y-m-d H:i:s');
            $fileName = $fs->info($migrationFile)->getFilename();
            $migrationClass = 'App\\Migration\\'. $fileName.$time;
        }
    }
    */
}