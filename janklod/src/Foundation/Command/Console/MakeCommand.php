<?php
namespace Jan\Foundation\Command\Console;

use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Command\Exception\CommandException;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;
use Jan\Foundation\Command\Console\Service\CommandService;

/**
 * Class MakeCommand
 *
 * @package Jan\Foundation\Command\Console
*/
class MakeCommand extends Command
{

    const EXISTED  = 5;
    const CREATED  = 6;



    /** @var string  */
    protected $name = 'make:command';



    /** @var string  */
    protected $description = 'Generate a new command';




    /**
     * @var CommandService
    */
    protected $service;



    /**
     * @var array
    */
    protected $messages = [
        self::EXISTED => 'Command (%s) already exist!',
        self::CREATED => 'Command %s generated successfully!'
    ];




    /**
     * @param string|null $name
    */
    public function __construct(CommandService $service, string $name = null)
    {
         parent::__construct($name);
         $this->service = $service;
    }




    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
   */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {

            $commandName = $input->getArgument(); // get the first argument

            if ($targetPath = $this->service->generate($commandName)) {
                $output->write(sprintf('Command %s generated successfully!', $targetPath));
                return Command::SUCCESS;
            }

        } catch (\Exception $e) {

            $output->write($e->getMessage());
            return Command::FAILURE;
        }
    }
}