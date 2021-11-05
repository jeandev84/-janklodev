<?php
namespace Jan\Component\Database\Connection\PDO;


use Exception;
use Jan\Component\Database\Connection\Contract\QueryInterface;
use Jan\Component\Database\Connection\Exception\QueryException;
use PDO;
use PDOException;
use PDOStatement;



/**
 * Class Query
 *
 * @package Jan\Component\Database\Connection\PDO
*/
class Query implements QueryInterface
{


       /**
        * @var PDO
       */
       protected $pdo;




       /**
        * @var PDOStatement
       */
       protected $statement;




       /**
        * @var string
       */
       protected $sql;




       /**
        * @var array
       */
       protected $params;




       /**
        * @var int
       */
       protected $fetchMode = PDO::FETCH_OBJ;






       /**
         * @var string
       */
       protected $entityClass;





       /**
        * @var array
       */
       protected $bindValues = [];




       /**
        * @var array
       */
       protected $cache = [];




       /**
         * @param PDO $pdo
       */
       public function __construct(PDO $pdo)
       {
            $this->pdo = $pdo;
       }





       /**
        * @param string $sql
        * @return $this
       */
       public function query(string $sql): Query
       {
           $this->sql = $sql;

           return $this;
       }




       /**
        * @param array $params
        * @return Query
       */
       public function params(array $params): Query
       {
           $this->params = $params;

           return $this;
       }




       /**
         * @param int $fetchMode
         * @return $this
       */
       public function fetchMode(int $fetchMode): Query
       {
           $this->fetchMode = $fetchMode;

           return $this;
       }





       /**
         * @param string|null $entityClass
         * @return $this
       */
       public function metaClass(string $entityClass): Query
       {
            $this->entityClass = $entityClass;

            return $this;
       }



       /**
         * @param string $param
         * @param $value
         * @param int $type
         * @return $this
       */
       public function bindValue(string $param, $value, int $type = 0): Query
       {
            $this->bindValues[] = [$param, $value, $type];

            return $this;
       }




       /**
        * @throws Exception
        *
        * @return void
       */
       public function execute()
       {
           try {

               $this->statement = $this->pdo->prepare($this->sql);

               if ($this->bindValues) {
                   $params = [];
                   foreach ($this->bindValues as $bindValue) {
                       list($param, $value, $type) = $bindValue;
                       $this->statement->bindValue($param, $value, $type);
                       $params[$param] = $value;
                   }

                   if ($this->statement->execute()) {
                       $this->addToCache($this->sql, $params);
                   }
               } else {

                   if ($this->statement->execute($this->params)) {
                       $this->addToCache($this->sql, $this->params);
                   }
               }

           } catch (PDOException $e) {

                throw new QueryException($e->getMessage());
           }
       }



       /**
         * @return array|false
         * @throws Exception
       */
       public function getArrayResult()
       {
            $this->execute();

            return $this->statement->fetchAll();
       }



       /**
         * @return array|false
         * @throws Exception
        */
        public function getArrayAssoc()
        {
            $this->execute();

            return $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }


         /**
          * @throws Exception
         */
         public function getArrayColumns()
         {
             $this->execute();

             return $this->statement->fetchAll(PDO::FETCH_COLUMN);
         }





        /**
         * @return array
         * @throws Exception
        */
        public function getResult(): array
        {
            $this->execute();

            if ($this->entityClass) {
                 $this->statement->setFetchMode(PDO::FETCH_CLASS, $this->entityClass);
                 return $this->statement->fetchAll();
            }

            return $this->statement->fetchAll($this->fetchMode);
        }




        /**
         * @return mixed
         * @throws Exception
        */
        public function getFirstResult()
        {
            $result = $this->getResult();

            return $result[0] ?? null;
        }



        /**
          * @return mixed
          * @throws Exception
        */
        public function getOneOrNullResult()
        {
            $this->execute();

            if($this->entityClass) {
                $this->statement->setFetchMode(PDO::FETCH_CLASS, $this->entityClass);
                return $this->statement->fetch();
            }

            return $this->statement->fetch($this->fetchMode);
        }


        /**
          * @param string $sql
          * @param array $params
        */
        public function addToCache(string $sql, array $params)
        {
            $this->cache[$sql] = $params;
        }

}