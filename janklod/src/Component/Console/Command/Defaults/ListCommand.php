<?php
namespace Jan\Component\Console\Command\Defaults;

use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * Class ListCommand
 *
 * @package Jan\Component\Console\Command\Defaults
*/
class ListCommand extends Command
{

    /**
     * @var string
    */
    protected $name = 'list';


    /**
     * @var string
    */
    protected $description = 'describe all available commands of the system.';



    /**
     * @var array
    */
    protected $commandStack = [];



    /**
     * @param array $commandStack
    */
    public function setCommands(array $commandStack)
    {
        $this->commandStack = $commandStack;
    }



    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
    */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
         return $this->showCommandList($output);
    }




    /**
     * @param OutputInterface $output
    */
    protected function showCommandList(OutputInterface $output)
    {
         $commands = [];
         $commandNamed = [];

         $output->writeln("Available commands using terminal :");
         $output->writeln("=======================================================================");
         $output->writeln("$ php bin/console command arg0 -arg=value -option=value -flag1 --flag2");

         $output->writeln("");
         $output->writeln("Defaults commands:");
         $output->writeln("-------------------");
         $output->writeln(" list            List all available commands.");
         $output->writeln(" -h or --help    Get command help example : $ php bin/console command -h");

         $output->writeln("");

         foreach ($this->commandStack as $name => $command) {
              if (stripos($name, ':') !== false) {
                   $name = explode(':', $name, 2)[0];
                   $commandNamed[$name][] = $command;
              }else{
                  $commands[] = $name;
              }
         }

         $output->writeln("List of Commands:");
         $output->writeln("-------------------");

         if ($commands) {
             foreach ($commands as $cmd) {
                 $output->writeln(" " . $cmd);
             }
             $output->writeln("");
         }

         if ($commandNamed) {
             foreach ($commandNamed as $name => $cmdStack) {
                 $output->writeln($name);
                 foreach ($cmdStack as $cmdObj) {
                     $output->writeln(sprintf(" %s          %s", $cmdObj->getName(), $cmdObj->getDescription()));
                 }
             }
         }

         $output->writeln("");

         return Command::SUCCESS;
    }
}