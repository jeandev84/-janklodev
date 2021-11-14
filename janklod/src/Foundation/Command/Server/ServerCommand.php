<?php
namespace Jan\Foundation\Command\Server;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * Class ServerCommand
 *
 * @package Jan\Foundation\Command\Server
*/
class ServerCommand extends Command
{

    /* const CMD = 'php -S localhost:%s -t %s -d display_errors=1'; */
    const EXEC_CMD = 'php -S localhost:%s -t %s';

    const WEBROOT = 'public';
    const D_ERROR = 1;
    const PORT = '8888';



    /**
     * @var string
    */
    protected $name = 'server:run';



    /**
     * @var string
    */
    protected $description = 'Lunch application server on the specific port.';




    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
    */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
         $output->writeln(sprintf('Server Listen on the port :%s', self::PORT));
         $output->writeln(sprintf('Open to your browser next link http://localhost:%s', self::PORT));
         /* $output->exec(sprintf('php -S 127.0.0.1:%s -t public -d display_errors=1', self::PORT)); */
         $output->exec(sprintf('php -S 127.0.0.1:%s -t public', self::PORT));

         return Command::SUCCESS;
    }
}