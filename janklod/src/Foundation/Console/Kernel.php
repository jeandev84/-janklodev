<?php
namespace Jan\Foundation\Console;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Console;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;
use Jan\Contract\Console\Kernel as ConsoleKernelContract;
use Jan\Foundation\Application;


/**
 * Class Kernel
 * @package Jan\Foundation\Console
*/
class Kernel implements ConsoleKernelContract
{

    /**
     * @var array
    */
    protected $commands = [];



    /**
     * @var Application
    */
    protected $app;



    /**
     * @var Console
    */
    protected $console;




    /**
     * @param Application $app
     * @param Console $console
    */
    public function __construct(Application $app, Console $console)
    {
         $this->app = $app;
         $this->console = $console;
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     * @throws \Exception
    */
    public function handle(InputInterface $input, OutputInterface $output)
    {
         $commands = array_merge(self::getDefaultCommands(), $this->commands);

         $this->loadCommands($commands);

         return $this->console->run($input, $output);
    }



    /**
     * @param InputInterface $input
     * @param mixed $status
     * @return mixed|void
    */
    public function terminate(InputInterface $input, $status)
    {
          // TODO add color and message from input

          if ($status === Command::SUCCESS) {
              // TODO add success
          }


          if ($status === Command::FAILURE) {
              // TODO add failure
          }


          if ($status === Command::INVALID) {
              // TODO add invalid
          }

          return $status;
    }


    /**
     * @param array $commands
     * @throws \Exception
    */
    protected function loadCommands(array $commands)
    {
         foreach ($commands as $command) {

             $command = $this->app->get($command);

             if ($command instanceof Command) {
                 $this->console->addCommand($command);
             }
         }
    }



    /**
     * @return string[]
    */
    protected static function getDefaultCommands(): array
    {
        return [
            \Jan\Foundation\Command\Server\ServerCommand::class,
            \Jan\Foundation\Command\Console\MakeCommand::class,
            \Jan\Foundation\Command\Module\MakeControllerCommand::class,
            \Jan\Foundation\Command\Module\MakeResourceCommand::class,
            \Jan\Foundation\Command\Migration\CreateMigrationCommand::class,
            \Jan\Foundation\Command\Migration\MigrateCommand::class,
            \Jan\Foundation\Command\Migration\RollbackCommand::class,
            \Jan\Foundation\Command\Migration\ResetCommand::class,
            \Jan\Foundation\Command\Capsule\CreateDatabaseCommand::class,
            \Jan\Foundation\Command\Debug\DebugRouterCommand::class
        ];
    }
}