<?php
namespace Jan\Component\Console\Command\Contract;


use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;

/**
 * Interface CommandInterface
 *
 * @package Jan\Component\Console\Command\Contract
*/
interface CommandInterface
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
    */
    public function execute(InputInterface $input, OutputInterface $output);
}