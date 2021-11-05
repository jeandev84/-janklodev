<?php
namespace Jan\Component\Database\ORM\Records\Support;


use Jan\Component\Database\ORM\Query\QueryBuilder;
use Jan\Component\Database\ORM\EntityManager;
use Jan\Component\Database\ORM\Contract\EntityManagerInterface;
use ReflectionObject;



/**
 * Class ActiveRecord
 *
 * @package Jan\Component\Database\ORM\Records\Support
*/
abstract class ActiveRecord
{


    /**
     * @var EntityManager
    */
    protected $em;



    /**
     * @var QueryBuilder
    */
    protected $qb;



    /**
     * @param EntityManagerInterface $em
    */
    public function __construct(EntityManagerInterface $em)
    {
         $this->em = $em;
         $this->qb = $em->createQueryBuilder();
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


    /**
     * @param object|string $context
     * @param null $name
     * @return string
     */
    public function makeTableName($context, $name = null): string
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