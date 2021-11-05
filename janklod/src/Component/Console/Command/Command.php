<?php
namespace Jan\Component\Console\Command;

use Jan\Component\Console\Command\Contract\CommandInterface;
use Jan\Component\Console\Command\Exception\CommandException;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Input\Support\InputArgument;
use Jan\Component\Console\Input\Support\InputBag;
use Jan\Component\Console\Input\Support\InputOption;
use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * class Command
 *
 * @package Jan\Component\Console\Command
*/
class Command implements CommandInterface
{

      const SUCCESS  = 0;
      const FAILURE  = 1;
      const INVALID  = 2;


      /**
       * name of command
       *
       * @var string
      */
      protected $name;



      /**
       * @var string
      */
      protected $defaultName = 'default';




      /**
       * @var string
      */
      protected $description = 'default command do something ...';



      /**
       * @var InputBag
      */
      protected $inputBag;




      /**
       * Command constructor.
       *
       * @param string|null $name
      */
      public function __construct(string $name = null)
      {
           $this->inputBag = new InputBag();

           if ($name) {
               $this->name = $name;
           }

           $this->configure();
      }




      /**
       * Configuration command
      */
      public function configure() {}




      /**
       * @param string $name
       * @param string $description
       * @param string $default
       * @return $this
      */
      public function addArgument(string $name, string $description = '', string $default = ''): Command
      {
           $this->inputBag->addArgument(
               new InputArgument($name, $description, $default)
           );

           return $this;
      }



      /**
       * add option
       *
       * @param string $name
       * @param string|null $shortcut
       * @param string $description
       * @param null $default
       * @return $this
      */
      public function addOption(string $name, string $shortcut = null, string $description = '', $default = null): Command
      {
          $this->inputBag->addOption(
              new InputOption($name, $shortcut, $description, $default)
          );

          return $this;
      }



      public function getOptions(): array
      {
          return $this->inputBag->getOptions();
      }


      /**
       * Set name of command
       *
       * @param string $name
       * @return Command
      */
      public function setName(string $name): Command
      {
          $this->name = $name;

          return $this;
      }



      /**
       * @return string|null
      */
      public function getName(): ?string
      {
          if (! $this->name) {
              return $this->defaultName;
          }

          // todo validation name
          return $this->name;
      }




      /**
        * @param string $description
        * @return $this
      */
      public function setDescription(string $description): Command
      {
           $this->description = $description;

           return $this;
      }




      /**
       * @return string
      */
      public function getDescription(): string
      {
          return $this->description;
      }





      /**
       * @param InputInterface $input
       * @param OutputInterface $output
       * @return mixed
       * @throws CommandException
      */
      public function execute(InputInterface $input, OutputInterface $output)
      {
           throw new CommandException('unable method execution command for class : '. get_called_class());
      }



      /**
       * @return InputBag
      */
      public function getInputBag(): InputBag
      {
          return $this->inputBag;
      }



      /**
       * @param string $name
       *
       * @return false|string
       */
      protected function validateCommandName(string $name)
      {
           if (preg_match("/^(\w+):(\w+)$/i", trim($name))) {
                return $name;
           }

           return false;
      }
}

/*

if($name = validateCommandName($this->name)) {
    return $name;
}

return $defaultCommand;
*/