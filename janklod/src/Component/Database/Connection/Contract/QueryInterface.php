<?php
namespace Jan\Component\Database\Connection\Contract;


/**
 * Class QueryInterface
 *
 * @package Jan\Component\Database\Connection\Contract
*/
interface QueryInterface
{
      public function query(string $sql);
      public function params(array $params);
      public function execute();
      public function getArrayResult();
      public function getArrayAssoc();
      public function getArrayColumns();
      public function getResult();
      public function getOneOrNullResult();
}