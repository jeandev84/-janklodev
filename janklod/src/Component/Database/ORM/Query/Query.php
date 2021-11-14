<?php
namespace Jan\Component\Database\ORM\Query;



use Exception;
use Jan\Component\Database\Connection\Connection;
use Jan\Component\Database\Connection\Contract\QueryInterface;
use Jan\Component\Database\ORM\Collection\ArrayCollection;


/**
 * Class Query
 *
 * @package Jan\Component\Database\ORM\Query
*/
class Query
{


    /**
     * @var ArrayCollection
    */
    protected $collections;



    /**
     * @var Connection
    */
    protected $connection;




    /**
     * @var QueryInterface
    */
    protected $query;




    /**
     * @var string
    */
    protected $entityClass = \stdClass::class;



    /**
     * Constructor Query
     *
     * @param Connection $connection
     * @param string|null $entityClass
    */
    public function __construct(Connection $connection, string $entityClass = null)
    {
        $this->connection = $connection;

        if ($entityClass) {
            $this->entityClass = $entityClass;
        }

        $this->collections = new ArrayCollection();
    }




    /**
     * @param string $sql
     * @param array $params
     * @return Query
     * @throws Exception
    */
    public function query(string $sql, array $params = []): Query
    {
        $this->query = $this->connection->query($sql, $params);
        $this->query->entityClass($this->entityClass);

        return $this;
    }




    /**
     * @return mixed
    */
    public function execute()
    {
        return $this->query->execute();
    }



    /**
     * @return array
     * @throws Exception
    */
    public function getArrayResult(): array
    {
        return $this->query->getArrayAssoc();
    }





    /**
     * @return array|false
     * @throws Exception
     */
    public function getArrayAssoc()
    {
        return $this->query->getArrayAssoc();
    }




    /**
     * @return array|false
     * @throws Exception
    */
    public function getArrayColumns()
    {
        return $this->query->getArrayColumns();
    }



    /**
     * @return array
     * @throws Exception
     */
    public function getResult(): array
    {
         $results = $this->query->getResult();

         $this->collects($results);

         return $results;
    }



    /**
     * @return mixed
     * @throws Exception
     */
    public function getFirstResult()
    {
        $result = $this->query->getFirstResult();

        $this->collect($result);

        return $result;
    }



    /**
     * @return mixed
     * @throws Exception
     */
    public function getOneOrNullResult()
    {
        $result = $this->query->getOneOrNullResult();

        $this->collect($result);

        return $result;
    }




    /**
     * @return array
    */
    public function getResultAsObjects(): array
    {
        return $this->collections->getValues();
    }




    /**
     * @param array $results
    */
    public function collects(array $results)
    {
        foreach ($results as $result) {
            $this->collect($result);
        }
    }



    /**
     * @param $result
    */
    public function collect($result)
    {
        if (is_object($result)) {
            $this->collections->add($result);
        }
    }
}