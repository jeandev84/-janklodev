<?php
namespace Jan\Component\Console\Output\Contract;


/**
 * Interface OutputInterface
 *
 * @package Jan\Component\Console\Output\Contract
*/
interface OutputInterface
{

     /**
      * @param string $message
      * @return mixed
     */
     public function write(string $message);


     /**
      * @param string $message
      * @return mixed
     */
     public function writeln(string $message);

     /**
      * @return string
     */
     public function getMessage(): string;
}