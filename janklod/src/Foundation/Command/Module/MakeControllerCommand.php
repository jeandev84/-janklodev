<?php
namespace Jan\Foundation\Command\Module;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;
use Jan\Foundation\Command\Module\Service\ModuleService;


/**
 * Class MakeControllerCommand
 *
 * @package Jan\Foundation\Command\Module
*/
class MakeControllerCommand extends Command
{


    /**
     * @var string
    */
    protected $name = 'make:controller';



    /**
     * @var ModuleService
    */
    protected $generator;


    /**
     * @param ModuleService $service
     * @param string|null $name
    */
    public function __construct(ModuleService $service, string $name = null)
    {
        parent::__construct($name);
        $this->generator = $service;
    }



    /**
     * Configure command parameters
    */
    public function configure()
    {
         $this->setDescription('Generate a new controller class.')
              ->addArgument('controller')
              ->addArgument('actions');
    }



    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
    */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
         #  php console make:controller -controller=HomeController -actions=index
         #  php console make:controller -controller=HomeController -actions=index,show,contact
         #  php console make:controller -controller=Admin\SayHelloController -action=index

         $controllerName   = $input->getArgument('controller');
         $actionNames      = $input->getArgument('actions');

         try {

            if($targetPath = $this->generator->generate($controllerName)) {
                $output->write(sprintf('Controller %s generated successfully!', $targetPath));
                return Command::SUCCESS;
            }

         } catch (\Exception $e) {
            $output->write($e->getMessage());
            return Command::FAILURE;
         }
    }
}