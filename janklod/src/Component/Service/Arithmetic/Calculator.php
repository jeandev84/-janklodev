<?php
namespace Jan\Component\Service\Arithmetic;


use Exception;

/**
 * Class Calculator
 * @package Jan\Component\Service\Arithmetic
*/
class Calculator
{

    /**
     * @param float $a
     * @param float $b
     * @return float
    */
    public function sum(float $a, float $b): float
    {
        return ($a + $b);
    }


    /**
     * @param float $a
     * @param float $b
     * @return float
    */
    public function subtract(float $a, float $b): float
    {
         return ($a - $b);
    }



    /**
     * @param float $a
     * @param float $b
     * @return float|int
    */
    public function multiple(float $a, float $b)
    {
        return ($a * $b);
    }


    /**
     * @param float $a
     * @param float $b
     * @return float|int
     * @throws Exception
    */
    public function divide(float $a, float $b)
    {
        if ($b == 0) {
            throw new Exception('Cannot divide number by zero.');
        }

        return ($a / $b);
    }
}