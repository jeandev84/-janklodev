<?php
namespace Jan\Component\Console;


use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;

/**
 * Interface ConsoleInterface
 *
 * @package Jan\Component\Console
*/
interface ConsoleInterface
{
    /**
      * Get all console commands
      *
      * @return mixed
    */
    public function getCommands();


    /**
     * Run parsed command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
    */
    public function run(InputInterface $input, OutputInterface $output);
}