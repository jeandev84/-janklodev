<?php
namespace Jan\Component\Database\ORM\Query;

use Jan\Component\Database\Builder\Support\SqlQueryBuilder;



/**
 * Class QueryBuilder
 *
 * @package Jan\Component\Database\ORM\Query
*/
class QueryBuilder extends SqlQueryBuilder
{

      /**
       * @var Query
      */
      protected $query;



      /**
       * @param Query $query
      */
      public function __construct(Query $query)
      {
           $this->query = $query;
      }




     /**
       * @return Query
       * @throws \Exception
     */
     public function getQuery(): Query
     {
          $this->query->query($this->getSQL(), $this->getParameters());

          return $this->query;
     }




     /**
       * @return void
       * @throws \Exception
      */
     public function execute()
     {
          $this->getQuery()->execute();
     }




    /**
     * @param string $table
     * @return SqlQueryBuilder
    */
    public function table(string $table): SqlQueryBuilder
    {
        $table = $this->generateTableName($table);

        return parent::table($table);
    }




    /**
     * @param string $context
     * @return string
    */
    protected function generateTableName(string $context): string
    {
        if (class_exists($context)) {
            $tableName =  (new \ReflectionClass($context))->getShortName();
            return mb_strtolower(trim($tableName, 's')). 's';
        }

        return $context;
    }
}