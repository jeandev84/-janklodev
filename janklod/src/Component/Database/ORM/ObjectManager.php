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
      */
      public function update($object)
      {
         if (is_object($object)) {
            if(method_exists($object, 'getId')) {
                if ($object->getId()) {
                    $this->updates[] = $object;
                }
            }
         }
      }




      /**
       * Add object to insert
       *
       * @param $object
      */
      public function persist($object)
      {
           if (is_object($object)) {
               if(method_exists($object, 'getId')) {
                   if (! $object->getId()) {
                       $this->insertions[] = $object;
                   }
               }
           }
      }




      /**
       * Add object to remove
       *
       * @param $object
      */
      public function remove($object)
      {
          if (is_object($object)) {
              if(method_exists($object, 'getId')) {
                  if ($object->getId()) {
                      $this->removes[] = $object;
                  }
              }
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
                foreach ($this->updates as $object) {
                    $record->update($this->getAttributes($object), $this->createTableName($object), ['id' => $object->getId()]);
                }
           }

           if ($this->insertions) {
               foreach ($this->insertions as $object) {
                   $record->insert($this->getAttributes($object), $this->createTableName($object));
               }
           }

           if ($this->removes) {
               foreach ($this->removes as $object) {
                   $record->delete($this->createTableName($object), ['id' => $object->getId()]);
               }
           }

           // End transaction
           // Flush privileges;
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
}