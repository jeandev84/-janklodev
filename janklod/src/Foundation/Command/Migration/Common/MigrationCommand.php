<?php
namespace Jan\Foundation\Command\Migration\Common;

use Jan\Component\Console\Command\Command;
use Jan\Component\Database\Migration\Migrator;
use Jan\Foundation\Command\Migration\Service\MigrationService;


/**
 * Class MigrationCommand
 *
 * @package Jan\Foundation\Command\Migration\Common
*/
abstract class MigrationCommand extends Command
{


    /**
     * @var MigrationService
    */
    protected $generator;



    /**
     * @var Migrator
    */
    protected $migrator;




    /**
     * @param MigrationService $service
     * @param Migrator $migrator
     * @param string|null $name
    */
    public function __construct(MigrationService $service, Migrator $migrator, string $name = null)
    {
        parent::__construct($name);
        $this->generator = $service;
        $this->migrator  = $migrator;
    }

}