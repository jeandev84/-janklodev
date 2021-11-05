<?php
namespace App\Command;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;
use Jan\Component\Console\Style\ConsoleStyle;


/**
 * Class ConsoleStyleCommand
 *
 * @package App\Command
*/
class ConsoleStyleCommand extends Command
{
     protected $name = 'app:console:color';


     public function execute(InputInterface $input, OutputInterface $output)
     {
          $style = new ConsoleStyle($input, $output);

          $style->success('Command created successfully!');

          return Command::SUCCESS;
     }
}