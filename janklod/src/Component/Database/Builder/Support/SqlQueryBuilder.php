<?php
namespace Jan\Component\Database\Builder\Support;


use Jan\Component\Database\Builder\Expr;
use Jan\Component\Database\Builder\Queries\Constraint;
use Jan\Component\Database\Builder\Queries\Delete;
use Jan\Component\Database\Builder\Queries\From;
use Jan\Component\Database\Builder\Queries\Insert;
use Jan\Component\Database\Builder\Queries\Select;
use Jan\Component\Database\Builder\Queries\Update;
use Jan\Component\Database\Builder\SqlBuilder;
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
     protected $sqlCommands = [];




     /**
      * @var array
     */
     protected $sqlConstraints = [];




     /**
      * @var array
     */
     protected $sqlParts = [];



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
         return $this->addSQLConstraints($condition);
     }



     /**
      * @param string $condition
      * @return $this|SqlQueryBuilder
     */
     public function andWhere(string $condition): SqlQueryBuilder
     {
         return $this->addSQLConstraints($condition, 'AND');
     }




     /**
      * @param string $condition
      * @return SqlQueryBuilder
     */
     public function orWhere(string $condition): SqlQueryBuilder
     {
         return $this->addSQLConstraints($condition, "OR");
     }



     /**
      * @param string $condition
      * @return SqlQueryBuilder
     */
     public function notWhere(string $condition): SQlQueryBuilder
     {
        return $this->addSQLConstraints($condition, "NOT");
     }



    /**
     * @param string $pattern
     * @return $this
    */
    public function whereLike(string $pattern): SqlQueryBuilder
    {
        return $this->addSQLConstraints($pattern, "LIKE");
    }


    /**
     * @param $first
     * @param $end
     * @return SqlQueryBuilder
    */
    public function whereBetween($first, $end): SqlQueryBuilder
    {
        return $this->addSQLConstraints("$first AND $end", "BETWEEN");
    }


    /**
     * @param array $data
     * @return $this
     */
    public function whereIn(array $data): SqlQueryBuilder
    {
        return $this->addSQLConstraints("(". implode(', ', $data).")", "IN");
    }



    /**
     * @param array $data
     * @return $this
     */
    public function whereNotIn(array $data): SqlQueryBuilder
    {
        return $this->addSQLConstraints("(". implode(', ', $data).")", "NOT IN");
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

         foreach ($this->sqlCommands as $command) {
             if (! $command instanceof SqlBuilder) {
                 if (\is_array($command)) {
                     foreach ($command as $c) {
                         $parts[] = $c->buildSQL();
                     }
                 }
             } else {
                 if ($command->isStart()) {
                     $start = $command->buildSQL();
                 }else{
                     $parts[] = $command->buildSQL();
                 }
             }
         }

         return sprintf('%s %s', $start, join(' ', $parts));
     }



     /**
      * @param SqlBuilder $command
      * @return $this
     */
     protected function addSQL(SqlBuilder $command): SqlQueryBuilder
     {
          $command->setAlias($this->alias);

          if ($this->table) {
              $command->setTable($this->table);
          }

          $this->sqlCommands[$command->getName()] = $command;
          $this->sqlParts[$command->getName()] = $command->buildSQL();

          return $this;
    }




    /**
     * @param string $condition
     * @param string|null $operator
     * @return $this
    */
    protected function addSQLConstraints(string $condition, string $operator = ''): SqlQueryBuilder
    {
        $expression = new Constraint($condition);

        if (empty($this->sqlCommands[$expression->getName()])) {

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

        $this->sqlCommands[$expression->getName()][] = $expression;
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