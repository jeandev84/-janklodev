<?php
namespace App\Service;


/**
 * Class Calculator
 * @package App\Service
*/
class Calculator
{

     /**
      * @var int
     */
     public $a;


     /**
      * @var int
     */
     public $b;



     /**
      * @var int
     */
     protected $result;


      /**
       * @param float $a
       * @param float $b
       * @return $this
     */
     public function sum(float $a = 0, float $b = 0): Calculator
     {
         $this->a = $a;
         $this->b = $b;

         $this->result = $this->a + $this->b;

         return $this;
     }



     /**
      * @return int
     */
     public function calculate()
     {
         return "Sum {$this->a} + {$this->b} = ". $this->result;
     }
}