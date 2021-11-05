<?php
namespace Jan\Component\Console\Style;


use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;

/**
 * Class ConsoleStyle
 *
 * @package Jan\Component\Console\Style
*/
class ConsoleStyle
{
     /**
      * @var InputInterface
     */
     protected $input;



     /**
      * @var OutputInterface
     */
     protected $output;


     /**
      * @param InputInterface $input
      * @param OutputInterface $output
     */
     public function __construct(InputInterface $input, OutputInterface $output)
     {
          $this->input  = $input;
          $this->output = $output;
     }


     public function green()
     {

     }


     public function red()
     {

     }


     public function yellow()
     {

     }


     /**
      * @param string $message
     */
     public function success(string $message)
     {
         $this->colorLog($message, 'success');
     }



     /**
      * @param string $message
     */
     public function info(string $message)
     {
         $this->colorLog($message, 'info');
     }



    /**
     * @param string $message
    */
    public function warning(string $message)
    {
        $this->colorLog($message, 'warning');
    }




    /**
     * @param string $message
    */
    public function error(string $message)
    {
        $this->colorLog($message, 'error');
    }


    /**
     * @param string $str
     * @param string $type
    */
    protected function colorLog(string $str, string $type = 'info')
    {
         switch ($type) {
             case 'error': //error
                 echo "\033[31m$str \033[0m\n";
                 break;
             case 'success': //success
                 echo "\033[32m$str \033[0m\n";
                 break;
             case 'warning': //warning
                 echo "\033[33m$str \033[0m\n";
                 break;
             case 'info': //info
                 echo "\033[36m$str \033[0m\n";
                 break;
             default:
                 # code...
                 break;
         }
     }
}