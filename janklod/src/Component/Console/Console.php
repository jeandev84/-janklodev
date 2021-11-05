<?php
namespace Jan\Component\Console;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Command\Defaults\HelpCommand;
use Jan\Component\Console\Command\Defaults\ListCommand;
use Jan\Component\Console\Command\Exception\CommandException;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * Class Console
 *
 * @package Jan\Component\Console
*/
class Console implements ConsoleInterface
{

     /**
      * @var string
     */
     protected $defaultCommand = 'list';



     /**
      * @var array
     */
     protected $commands = [];


    /**
     * Console constructor
     * @throws CommandException
     */
     public function __construct()
     {
          $this->addCommands([
             new ListCommand(),
             new HelpCommand()
          ]);


     }



     /**
      * @return array
     */
     public function getDefaultCommands(): array
     {
         return [
             new ListCommand(),
             new HelpCommand()
         ];
     }



     /**
      * @param Command $command
      * @return $this
      * @throws CommandException
     */
     public function addCommand(Command $command): Console
     {
         if (! $name = $command->getName()) {
              throw new CommandException("unable name of command : ". \get_class($command));
         }

         /*
         if (\array_key_exists($name, $this->commands)) {
             throw new CommandException("This command name (" . $name . ") already taken!");
         }
         */

         $this->commands[$name] = $command;

         return $this;
     }


    /**
     * @param array $commands
     * @return Console
     * @throws CommandException
     */
     public function addCommands(array $commands): Console
     {
         foreach ($commands as $command) {
             $this->addCommand($command);
         }

         return $this;
     }


     /**
      * @param string $name
      * @return bool
     */
     public function hasCommand($name): bool
     {
         return \array_key_exists($name, $this->commands);
     }



     /**
      * @return array
     */
     public function getCommands(): array
     {
         return $this->commands;
     }


     /**
      * @throws CommandException
     */
     public function getCommand($name)
     {
         if (! $this->hasCommand($name)) {
               throw new CommandException('Invalid command name.');
         }

         return $this->commands[$name];
     }




     /**
      * Remove command
      *
      * @param string $name
     */
     public function removeCommand(string $name)
     {
         unset($this->commands[$name]);
     }


     /**
       * @param array $names
     */
     public function removeCommands(array $names)
     {
         foreach ($names as $name) {
             $this->removeCommand($name);
         }
     }




     /**
      * @param InputInterface $input
      * @param OutputInterface $output
      * @return mixed
     */
     public function run(InputInterface $input, OutputInterface $output)
     {
         try {

             $name = $input->getFirstArgument();

             if (! $name ) {
                 $name = $this->getDefaultCommand();
             } else {
                 if (\in_array($name, ['-h', '--help'])) {
                     $name = 'help';
                 }
             }


             /** @var Command $command */
             $command = $this->getCommand($name);

             $inputBag = $command->getInputBag();
             $input->parses($inputBag);

             if ($command instanceof ListCommand) {
                 $this->removeCommands(['list', 'help']);

                 $command->setCommands($this->commands);
             }

             $status = $command->execute($input, $output);
             echo $output->getMessage();

             return $status;

         } catch (\Exception $e) {

             echo $e->getMessage();
             return Command::FAILURE;
         }

     }



     /**
      * @return string
     */
     protected function getDefaultCommand(): string
     {
         return $this->defaultCommand;
     }
}

/*
$  php console make:controller  a0 a=1 b=2 c=3 -name=jean -name --env=prod  --env
*/