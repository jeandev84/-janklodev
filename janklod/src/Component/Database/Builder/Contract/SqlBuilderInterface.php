<?php
namespace Jan\Component\Database\Builder\Contract;


/**
 * SqlBuilderInterface
 *
 * @package Jan\Component\Database\Builder\Contract
*/
interface SqlBuilderInterface
{
    /**
     * @return string
    */
    public function buildSQL(): string;
}