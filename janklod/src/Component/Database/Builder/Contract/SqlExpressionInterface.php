<?php
namespace Jan\Component\Database\Builder\Contract;


/**
 * SqlExpressionInterface
 *
 * @package Jan\Component\Database\Builder\Contract
*/
interface SqlExpressionInterface
{
    /**
     * @return string
    */
    public function buildSQL(): string;
}