<?php
namespace Jan\Component\Database\Connection\Contract;


/**
 * Class QueryResultInterface
 *
 * @package Jan\Component\Database\Connection\Contract
*/
interface QueryResultInterface
{
    public function getArrayResult();
    public function getArrayAssoc();
    public function getArrayColumns();
    public function getResult();
    public function getOneOrNullResult();
}