<?php
namespace Jan\Foundation\Command\Migration;

use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;
use Jan\Foundation\Command\Migration\Common\MigrationCommand;


/**
 * Class ResetCommand
 *
 * @package Jan\Foundation\Command\Migration\Common\MigrationCommand
*/
class ResetCommand extends MigrationCommand
{
    /**
     * @var string
    */
    protected $name = 'migration:reset';



    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->migrator->reset();

        /* dump($this->migrator->getMigrations()); */

        return Command::SUCCESS;
    }
}