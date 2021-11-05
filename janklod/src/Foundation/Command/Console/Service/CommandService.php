<?php
namespace Jan\Foundation\Command\Console\Service;


use Jan\Foundation\Command\CommandStub;
use InvalidArgumentException;
use Jan\Foundation\Utils\Str;


/**
 * Class CommandService
 *
 * @package Jan\Foundation\Command\Console\Service
*/
class CommandService extends CommandStub
{
    /**
     * @throws \Exception
    */
    public function generate($commandName)
     {
         if (stripos($commandName, ':') === false) {
              throw new InvalidArgumentException('Invalid command name. (reference method '. __METHOD__.')');
         }

         $parts = explode(':', $commandName);
         $commandClass = end($parts);
         $prefix = '';

         if (count($parts) === 3) {
             $prefix = $parts[1];
         }

         $commandClass = $this->toCamelCaseCommandName($commandClass);
         $prefix       = $this->toCamelCaseCommandName($prefix);

         $commandClass = ucfirst($prefix) . ucfirst($commandClass).'Command';

         $stub = $this->replaceStub('command', [
             'CommandClass' => $commandClass,
             'CommandNamespace' => 'App\\Command',
             'commandName' => $commandName,
             'commandDescription' => 'some description of command ...'
         ]);


         // TODO change path to controller and do it globally
         $targetPath = sprintf('app/Command/%s.php', $commandClass);
         $targetPath = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $targetPath);

         if ($this->fileSystem->exists($targetPath)) {
             throw new \Exception(
                 sprintf('Command (%s) already exist!', $commandClass)
             );
         }

         $this->fileSystem->make($targetPath);
         $this->fileSystem->write($targetPath, $stub);

         return $targetPath;
     }


     /**
      * @param $input
      * @return string
     */
     protected function toCamelCaseCommandName($input): string
     {
         return ucfirst(str_replace(['-', '_'], '', ucwords($input, "-\\_")));
     }
}


/*
PS C:\xampp\htdocs\janframework> php console make:command app:user:create
Command app\Command\UserCreateCommand.php generated successfully!
PS C:\xampp\htdocs\janframework> php console make:command app:change
Command app\Command\ChangeCommand.php generated successfully!
PS C:\xampp\htdocs\janframework> php console make:command app:user:change-password
Command app\Command\UserChangePasswordCommand.php generated successfully!
PS C:\xampp\htdocs\janframework> php console make:command app:user-fill:federal
Command app\Command\UserFillFederalCommand.php generated successfully!
PS C:\xampp\htdocs\janframework> cle
*/