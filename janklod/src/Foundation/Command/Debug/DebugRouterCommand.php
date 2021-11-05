<?php
namespace Jan\Foundation\Command\Debug;

use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;
use Jan\Component\Container\Container;
use Jan\Component\Routing\Router;
use Jan\Component\Routing\Route;
use Jan\Foundation\Application;


/**
 * Class DebugRouterCommand
 *
 * @package Jan\Foundation\Command\Debug
*/
class DebugRouterCommand extends Command
{

    /**
     * @var string
    */
    protected $name = 'debug:router';


    /**
     * @var string
    */
    protected $description = 'give a details available routes.';




    /**
     * @var Application
    */
    protected $app;



    /**
     * @param Application $app
     * @param string|null $name
    */
    public function __construct(Application $app, string $name = null)
    {
        parent::__construct($name);
        $this->app = $app;
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
    */
    public function execute(InputInterface $input, OutputInterface $output)
    {
          // methods path callback name
          $output->writeln($this->getHeaderBlank());

          foreach ($this->app['_routes'] as $route) {
               $output->writeln("");
               // $output->writeln($this->blankList($route));
          }

          return Command::SUCCESS;
    }


    /**
     * @param Route $route
     * @return string
    */
    protected function blankList(Route $route): string
    {
        return sprintf($this->getDetailBlank(),
            $route->toStringMethods(),
            $route->getPath(),
            $route->getCallback() instanceof \Closure ? '#Closure' : $route->getCallback(),
            $route->getName()
        );
    }


    /**
     * @return string
    */
    protected function getDetailBlank(): string
    {
        return "|---------------------|---------------------|--------------------------------------------|------------------|
                | %s                  | %s                  | %s                                         | %s               |
                |---------------------|---------------------|--------------------------------------------|------------------|
               ";
    }


    /**
     * @return string
    */
    protected function getHeaderBlank(): string
    {
        return "|---------------------|---------------------|--------------------------------------------|------------------|
                |       Methods       |        Path         |                   Callback                 |       Name       |
                |---------------------|---------------------|--------------------------------------------|------------------|
               ";
    }
}