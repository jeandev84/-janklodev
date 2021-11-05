<?php
namespace Jan\Foundation\Command\Migration;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;
use Jan\Foundation\Command\Migration\Common\MigrationCommand;


/**
 * Class MakeMigrationCommand
 *
 * @package Jan\Foundation\Command
*/
class CreateMigrationCommand extends MigrationCommand
{

    /**
     * @var string
    */
    protected $name = 'make:migration';



    /**
     * @var string
    */
    protected $description = "make migration class ...";


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
    */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        if($path = $this->generator->generateMigrationFile()) {
            $output->write(sprintf('Migration %s created successfully...', $path));
        }

        return Command::SUCCESS;
    }
}