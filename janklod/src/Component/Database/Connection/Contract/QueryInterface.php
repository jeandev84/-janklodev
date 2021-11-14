<?php
namespace Jan\Component\Database\Connection\Contract;


/**
 * Class QueryInterface
 *
 * @package Jan\Component\Database\Connection\Contract
*/
interface QueryInterface extends QueryResultInterface
{
      public function query(string $sql);
      public function params(array $params);
      public function entityClass(string $entityClass);
      public function execute();
}