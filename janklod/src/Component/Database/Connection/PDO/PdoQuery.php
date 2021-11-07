<?php
namespace Jan\Component\Database\Connection\PDO;

use Exception;
use Jan\Component\Database\Connection\Exception\QueryException;
use Jan\Component\Database\Connection\Query;
use PDO;
use PDOException;
use PDOStatement;




/**
 * Class PdoQuery
 *
 * @package Jan\Component\Database\Connection\PDO
*/
class PdoQuery extends Query
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
     * @var int
    */
    protected $fetchMode = PDO::FETCH_OBJ;




    /**
     * @var string
    */
    protected $entityClass = \stdClass::class;





    /**
     * @var array
    */
    protected $bindValues = [];





    /**
     * @var mixed
     */
    protected $result;



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
     * @param int $fetchMode
     * @return Query
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
    public function entityClass(string $entityClass): Query
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
                    $this->statement->bindValue(':'. $param, $value, $type);
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

            /*
            $this->results = $this->fetchAll();
            $this->result  = $this->fetch($this->fetchMode);
            */


        } catch (PDOException $e) {

            $this->addToCache($this->sql, $this->params);

            throw new QueryException($e->getMessage());
        }
    }



    /**
     * @return array
     * @throws Exception
    */
    public function getArrayResult(): array
    {
        $this->execute();

        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
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
            return $this->statement->fetchObject($this->entityClass);
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