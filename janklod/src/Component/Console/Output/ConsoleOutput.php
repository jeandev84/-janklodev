<?php
namespace Jan\Component\Console\Output;


use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * Class ConsoleOutput
 * @package Jan\Component\Console\Output
 */
class ConsoleOutput implements OutputInterface
{
     /**
      * @var array
     */
     protected $message = [];


     /**
      * @param string $message
      * @return ConsoleOutput
     */
     public function write(string $message): ConsoleOutput
     {
          $this->message[] = $message;

          return $this;
     }



     /**
      * @param string $message
      * @return ConsoleOutput
     */
     public function writeln(string $message): ConsoleOutput
     {
         return $this->write($message ."\n");
     }


    /**
     * @param string $command
     * @return ConsoleOutput
    */
    public function exec(string $command): ConsoleOutput
    {
         if ($this->message) {
             echo $this->getMessage() . "\n";
         }
         shell_exec($command);
    }


     /**
      * @return string
     */
     public function getMessage(): string
     {
         return implode("", $this->message);
     }

}