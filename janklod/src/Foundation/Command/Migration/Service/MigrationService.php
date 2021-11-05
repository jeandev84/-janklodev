<?php
namespace Jan\Foundation\Command\Migration\Service;

use Jan\Foundation\Command\CommandStub;


/**
 *
*/
class MigrationService extends CommandStub
{

       // TODO implements method generate in the parent class [ generate(array $arguments) ]
       public function generateMigrationFile()
       {
           $migrationClass = 'Version'. date('YmdHis');
           $stub = $this->replaceStub('migration', [
               'MigrationClass'      => $migrationClass,
               'MigrationNamespace'  => 'App\\Migration',
               'tableName'           => 'foo' // TODO dynamic
           ]);


           // TODO change path to controller and do it globally
           $targetPath = sprintf('app/Migration/%s.php', $migrationClass);
           $targetPath = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $targetPath);

           $this->fileSystem->make($targetPath);
           $this->fileSystem->write($targetPath, $stub);

           return $targetPath;
       }
}