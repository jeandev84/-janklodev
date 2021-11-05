<?php
namespace Jan\Foundation\Command\Migration;

use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;
use Jan\Foundation\Command\Migration\Common\MigrationCommand;


/**
 * Class MigrateCommand
 *
 * @package Jan\Foundation\Command\Migration\Common\MigrationCommand
*/
class MigrateCommand extends MigrationCommand
{

    /**
     * @var string
    */
    protected $name = 'migration:migrate';



    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
    */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
         $this->migrator->migrate();

         /* dump($this->migrator->getMigrations()); */

         return Command::SUCCESS;
    }
}