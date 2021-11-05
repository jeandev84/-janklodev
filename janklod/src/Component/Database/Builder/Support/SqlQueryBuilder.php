<?php
namespace Jan\Component\Database\Builder\Support;


use Jan\Component\Database\Builder\Expr;
use Jan\Component\Database\Builder\Queries\Constraint;
use Jan\Component\Database\Builder\Queries\Delete;
use Jan\Component\Database\Builder\Queries\From;
use Jan\Component\Database\Builder\Queries\Insert;
use Jan\Component\Database\Builder\Queries\Select;
use Jan\Component\Database\Builder\Queries\Update;
use Jan\Component\Database\Builder\SqlExpression;
use Jan\Component\Database\Utils\Str;

/**
 * Class SqlQueryBuilder
 *
 * @package Jan\Component\Database\Builder\Support
*/
class SqlQueryBuilder
{


     /**
      * table alias
      *
      * @var string
     */
     protected $alias;



     /**
      * @var string
     */
     protected $table;




     /**
      * @var array
     */
     protected $sqlExpressions = [];



     /**
      * @var array
     */
     protected $sqlParts = [];



     /**
      * @var array
     */
     protected $queriesLog = [];




     /**
      * @var array
     */
     protected $parameters = [];




     /**
      * @param string $table
      * @return $this
     */
     public function table(string $table): SqlQueryBuilder
     {
         $table = $this->generateTableName($table);

         $this->table = $table;

         if (! $this->alias) {
             $this->alias = Str::substr($table);
         }

         return $this;
     }




     /**
      * @param string $alias
      * @return $this
     */
     public function alias(string $alias): SqlQueryBuilder
     {
         $this->alias = $alias;

         return $this;
     }



     /**
      * @param string|array $fields
      * @return $this
     */
     public function select($fields = null): SqlQueryBuilder
     {
         return $this->addSQL(new Select($fields));
     }


     /**
      * @param string $table
      * @param string|null $alias
      * @return $this
     */
     public function from(string $table, string $alias = null): SqlQueryBuilder
     {
          $this->table($table);

          if ($alias) {
             $this->alias($alias);
          }

          return $this->addSQL(new From($table));
     }



     /**
      * @param string $condition
      * @return $this
     */
     public function where(string $condition): SqlQueryBuilder
     {
         return $this->addConditionSQL($condition);
     }



     /**
      * @param string $condition
      * @return $this|SqlQueryBuilder
     */
     public function andWhere(string $condition): SqlQueryBuilder
     {
         return $this->addConditionSQL($condition, 'AND');
     }




     /**
      * @param string $condition
      * @return SqlQueryBuilder
     */
     public function orWhere(string $condition): SqlQueryBuilder
     {
         return $this->addConditionSQL($condition, "OR");
     }



     /**
      * @param string $condition
      * @return SqlQueryBuilder
     */
     public function notWhere(string $condition): SQlQueryBuilder
     {
        return $this->addConditionSQL($condition, "NOT");
     }



    /**
     * @param string $pattern
     * @return $this
    */
    public function whereLike(string $pattern): SqlQueryBuilder
    {
        return $this->addConditionSQL($pattern, "LIKE");
    }


    /**
     * @param $first
     * @param $end
     * @return SqlQueryBuilder
    */
    public function whereBetween($first, $end): SqlQueryBuilder
    {
        return $this->addConditionSQL("$first AND $end", "BETWEEN");
    }


    /**
     * @param array $data
     * @return $this
     */
    public function whereIn(array $data): SqlQueryBuilder
    {
        return $this->addConditionSQL("(". implode(', ', $data).")", "IN");
    }



    /**
     * @param array $data
     * @return $this
     */
    public function whereNotIn(array $data): SqlQueryBuilder
    {
        return $this->addConditionSQL("(". implode(', ', $data).")", "NOT IN");
    }



     /**
      * Set query parameter
      *
      * @param string $key
      * @param $value
      * @return $this
     */
     public function setParameter(string $key, $value): SqlQueryBuilder
     {
         $this->parameters[$key] = $value;

         return $this;
     }



     /**
      * @return Expr
     */
     public function expr(): Expr
     {
         return new Expr($this);
     }



     /**
      * @param array $attributes
      * @param string $table
      * @return SqlQueryBuilder
     */
     public function insert(array $attributes, string $table = ''): SqlQueryBuilder
     {
          $this->setParameters($attributes);

          if ($table) {
              $this->table($table);
          }

          return $this->addSQL(new Insert($attributes));
     }



     /**
      * @param array $attributes
      * @param string $table
      * @return SqlQueryBuilder
     */
     public function update(array $attributes, string $table): SqlQueryBuilder
     {
           $this->setParameters($attributes);
           $this->table($table);

           return $this->addSQL(new Update($attributes));
     }



     /**
      * @param string $table
      * @return $this|SqlQueryBuilder
     */
     public function delete(string $table): SqlQueryBuilder
     {
         $this->table($table);

         return $this->addSQL(new Delete($table));
     }




     /**
      * Set query params
      *
      * @param array $parameters
      * @return SqlQueryBuilder
     */
     public function setParameters(array $parameters): SqlQueryBuilder
     {
         foreach ($parameters as $key => $value) {
              $this->setParameter($key, $value);
         }

         return $this;
     }



     /**
      * @return array
     */
     public function getParameters(): array
     {
         return $this->parameters;
     }





     /**
      * @return string
     */
     public function getSQL(): string
     {
         $start = '';
         $parts = [];

         foreach ($this->sqlExpressions as $context) {

             if (! $context instanceof SqlExpression) {
                 if (\is_array($context)) {
                     foreach ($context as $c) {
                         $parts[] = $c->buildSQL();
                     }
                 }
             } else {
                 if ($context->isStart()) {
                     $start = $context->buildSQL();
                 }else{
                     $parts[] = $context->buildSQL();
                 }
             }
         }

         $sql = sprintf('%s %s', $start, join(' ', $parts));
         $this->queriesLog[] = $sql;
         return $sql;
     }



     /**
      * @param SqlExpression $expression
      * @return $this
     */
     protected function addSQL(SqlExpression $expression): SqlQueryBuilder
     {
          $expression->setAlias($this->alias);

          if ($this->table) {
              $expression->setTable($this->table);
          }

          $this->sqlExpressions[$expression->getName()] = $expression;
          $this->sqlParts[$expression->getName()] = $expression->buildSQL();

          return $this;
    }




    /**
     * @param string $condition
     * @param string|null $operator
     * @return $this
    */
    protected function addConditionSQL(string $condition, string $operator = ''): SqlQueryBuilder
    {
        $expression = new Constraint($condition);

        if (empty($this->sqlExpressions[$expression->getName()])) {

            $expression->setOperator("WHERE");
            if ($operator && ! \in_array($operator, ["AND", "OR"])) {
                $expression->setOperator("WHERE {$operator}");
            }

        } else {

            if (! \in_array($operator, ["AND", "OR"])) {
                $operator = sprintf("AND %s", $operator);
            }

            $expression->setOperator($operator);
        }

        $this->sqlExpressions[$expression->getName()][] = $expression;
        $this->sqlParts[$expression->getName()][] = $expression->buildSQL();

        return $this;
    }



    /**
     * @return array
    */
    public function getSqlParts(): array
    {
        return $this->sqlParts;
    }



    /**
     * @return array
    */
    public function getQueriesLog(): array
    {
        return $this->queriesLog;
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


    /**
     * @param object|string $context
     * @param null $name
     * @return string
     */
    public function mak($context, $name = null): string
    {
        if (is_object($context)) {
            $name = (new ReflectionObject($context))->getShortName();
        } else {
            if (is_string($context) && class_exists($context)) {
                $name =  (new \ReflectionClass($context))->getShortName();
            }
        }

        return mb_strtolower(trim($name, 's')). 's';
    }
}

/*
$qb = new SqlQueryBuilder('u');

$qb->select('email, name, surname, patronymic, city')
   ->from('users')
   //->where('id = :id')
   ->notWhere('name = :name')
   //->notWhere('email = :email')
   //->andWhere('name = :name')
   //->andWhere('email = :email')
   ->orWhere('deletedAt IS NULL')
   //->orWhere('surname = :surname')
   ->setParameter('id', 1)
   ->setParameter('surname', 'jean')
   ->setParameters(['name' => 'Yao', 'email' => 'jeanyao@ymail.com']);

dump($qb->logSQL());

echo $qb->getSQL();
*/