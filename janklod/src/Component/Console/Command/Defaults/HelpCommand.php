<?php
namespace Jan\Component\Console\Command\Defaults;

use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * Class HelpCommand
 *
 * @package Jan\Component\Console\Command\Defaults
*/
class HelpCommand extends Command
{

    /**
     * @var string
    */
    protected $name = 'help';


    /**
     * @var string
    */
    protected $description = 'give more information each commands.';


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|mixed
    */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        echo "HELP COMMAND";
        return Command::SUCCESS;
    }
}