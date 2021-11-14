<?php
namespace Jan\Component\Database\ORM;


use Exception;
use InvalidArgumentException;
use Jan\Component\Database\Connection\Connection;
use Jan\Component\Database\Connection\PDO\PdoConfiguration;
use Jan\Component\Database\ORM\Query\Query;
use Jan\Component\Database\ORM\Query\QueryBuilder;
use Jan\Component\Database\ORM\Query\QueryBuilderFactory;
use Jan\Component\Database\ORM\Record\Persistence;
use Jan\Component\Database\ORM\Record\Deletion;
use Jan\Component\Database\Connection\PDO\PdoConnection;
use Jan\Component\Database\Managers\Contract\EntityManagerInterface;
use Jan\Component\Database\ORM\Record\Record;
use Jan\Component\Database\ORM\Repository\EntityRepository;
use PDO;
use ReflectionObject;


/**
 * Class EntityManager
 *
 * @package Jan\Component\Database\ORM
*/
class EntityManager extends ObjectManager implements EntityManagerInterface
{

    /**
     * @var PdoConnection
    */
    protected $connection;



    /**
     * @var string
    */
    protected $classMap;




    /**
     * @var Persistence
    */
    protected $persistence;



    /**
     * @var Deletion
    */
    protected $deletion;




    /**
     * @var QueryBuilderFactory
    */
    protected $builderFactory;




    /**
     * @var QueryBuilder
    */
    protected $qb;




    /**
     * @var array
    */
    protected $entities = [];



    /**
     * @var array
    */
    protected $metaObjects = [];


    /**
     * @param Connection $connection
     * @throws Exception
    */
    public function __construct(Connection $connection)
    {
          $this->connection     = $connection;
          $this->builderFactory = new QueryBuilderFactory($connection);
    }




    /**
     * Register entity class
     *
     * @param string $entity
     * @param EntityRepository $repository
    */
    public function map(string $entity, EntityRepository $repository)
    {
         $this->entities[$entity] = $repository;
    }





    /**
     * @param array $objects
    */
    public function setMetaObjects(array $objects)
    {
         foreach ($objects as $object) {
             $this->persist($object);
         }
    }



    /**
     * @param string $classMap
    */
    public function setClassMap(string $classMap)
    {
         $this->classMap = $classMap;
    }



    /**
     * @return string
     * @throws Exception
    */
    public function getClassMap(): string
    {
        if (! $this->classMap) {
            throw new Exception('no class mapped by entity manager.');
        }

        return $this->classMap;
    }





    /**
     * @return array
    */
    public function getEntities(): array
    {
        return $this->entities;
    }




    /**
     * Get repository
     *
     * @param string $entity
     * @return EntityRepository
    */
    public function getRepository(string $entity): EntityRepository
    {
        if (! isset($this->entities[$entity])) {
            throw new InvalidArgumentException('Cannot resolve entity ('. $entity . ') from storage repository.');
        }

        return $this->entities[$entity];
    }



    /**
     * @return mixed
     * @throws Exception
    */
    public function getConnection()
    {
        return $this->connection->getDriverConnection();
    }





    /**
     * @return PdoConfiguration
    */
    public function getConfiguration(): PdoConfiguration
    {
        return $this->connection->getConfiguration();
    }




    /**
     * @param string $sql
     * @return mixed
    */
    public function execQuery(string $sql)
    {
        return $this->connection->exec($sql);
    }



    /**
     * @return Query
     * @throws Exception
    */
    public function createQuery(): Query
    {
        return new Query($this->connection, $this->getClassMap());
    }




    /**
     * @return QueryBuilder
     * @throws Exception
    */
    public function createQueryBuilder(): QueryBuilder
    {
        return $this->qb = $this->builderFactory->make($this->createQuery());
    }



    /**
     * Flush to database
     *
     * @return void
     * @throws Exception
    */
    public function flush()
    {
        $objects = $this->qb->getQuery()->getResultAsObjects();

        // add to persist
        foreach ($objects as $object) {
            $this->update($object);
        }

        $this->flushPrivileges(new Record($this));
    }




    /**
     * @param object $object
     * @return array
    */
    public function getProperties(object $object): array
    {
        $mappedProperties = [];
        $reflectedObject = new ReflectionObject($object);

        foreach($reflectedObject->getProperties() as $property) {
            $property->setAccessible(true);
            $mappedProperties[$property->getName()] = $property->getValue($object);
        }

        return $mappedProperties;
    }
}


/*
$users = $repository->findAll();
dump($users);

$i = uniqid();
foreach ($users as $user) {
    $email = 'f'. $i .'@gmail.com';
    $user->setEmail($email);
    $user->setUsername($email);
    $i++;
}


$u = $repository->findOneBy(['id' => 9]);

$this->em->remove($u);

$this->em->flush();
*/