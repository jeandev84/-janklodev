<?php
namespace Jan\Component\Console\Input\Contract;


use Jan\Component\Console\Input\Support\InputBag;



/**
 * Interface InputInterface
 *
 * @package Jan\Component\Console\Input\Contract
*/
interface InputInterface
{

     /**
      * Get first argument of console
      *
      * @return mixed
     */
     public function getFirstArgument();




     /**
      * Parse arguments, options, flags ...
      *
      * @param InputBag $inputBag
      * @return mixed
     */
     public function parses(InputBag $inputBag);



     /**
      * @return mixed
     */
     public function getTokens();


     /**
      * @return mixed
     */
     public function getArgumentFlags();



     /**
      * @return mixed
     */
     public function getOptionFlags();



     /**
      * @return mixed
     */
     public function getArguments();


    /**
     * @return mixed
    */
    public function getOptions();



    /**
     * @param string|null $name
     * @return mixed|string
     */
    public function getArgument(string $name = null);
}