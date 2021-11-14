<?php
namespace Jan\Component\Database\ORM;

use Jan\Component\Database\Connection\Connection;
use Jan\Component\Database\ORM\Record\Record;
use ReflectionObject;

/**
 * Class ObjectManager
 *
 * @package Jan\Component\Database\ORM
*/
class ObjectManager
{

      /**
       * @var array
      */
      public $updates = [];




      /**
       * @var array
      */
      public $insertions = [];




      /**
       * @var array
      */
      public $removes = [];




      /**
       * Add object to update
       *
       * @param $object
       * @throws \Exception
      */
      public function update($object)
      {
          if ($object = $this->filterObject($object)) {
             $this->updates[] = $object;
          }
      }





      /**
       * Add object to insert
       *
       * @param $object
       * @throws \Exception
      */
      public function persist($object)
      {
          if ($object = $this->filterObject($object)) {
              $this->insertions[] = $this->filterObject($object);
          }
      }




      /**
       * Add object to remove
       *
       * @param $object
       * @throws \Exception
      */
      public function remove($object)
      {
          if ($object = $this->filterObject($object)) {
              $this->removes[] = $object;
          }
      }





      /**
       * @param Record $record
       * @throws \Exception
      */
      public function flushPrivileges(Record $record)
      {
           // Begin transaction

           if ($this->updates) {
               $this->updateRecords($record);
           }

           if ($this->insertions) {
               $this->insertRecords($record);
           }


           if ($this->removes) {
              $this->removeRecords($record);
           }

           // End transaction
           // Flush privileges;
     }




     /**
      * @throws \ReflectionException
      * @throws \Exception
     */
     protected function updateRecords(Record $record)
     {
         foreach ($this->updates as $object) {
             if ($id = $object->getId()) {
                 $record->update($this->getAttributes($object), $this->createTableName($object), ['id' => $id]);
             }
         }
     }




    /**
     * @param Record $record
     * @throws \ReflectionException
     * @throws \Exception
     */
     protected function insertRecords(Record $record)
     {
         foreach ($this->insertions as $object) {
             if (! $object->getId()) {
                 $record->insert($this->getAttributes($object), $this->createTableName($object));
             }
         }
     }




     /**
      * @throws \ReflectionException
      * @throws \Exception
     */
     protected function removeRecords(Record $record)
     {
         foreach ($this->removes as $object) {
             if ($idR = $object->getId()) {
                 $record->delete($this->createTableName($object), ['id' => $idR]);
             }
         }
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
     * @param $object
     * @return array
    */
    public function getAttributes($object): array
    {
        $params = $this->getProperties($object);
        unset($params['id']);

        return $params;
    }





    /**
     * @param $context
     * @return string
     * @throws \ReflectionException
    */
    protected function createTableName($context): string
    {
        $name = (new \ReflectionClass($context))->getShortName();

        return mb_strtolower(trim($name, 's')). 's';
    }


    /**
     * @param $object
     * @return mixed|null
     * @throws \Exception
    */
    public function filterObject($object)
    {
        if (! is_object($object)) {
            return null;
        }

        if(! method_exists($object, 'getId')) {
            throw new \Exception('Method getId() must be to implements.');
        }

        return $object;
    }



    /**
     * @param $object
     * @return mixed
     * @throws \Exception
    */
    public function getId($object)
    {
        return $this->filterObject($object)->getId();
    }
}