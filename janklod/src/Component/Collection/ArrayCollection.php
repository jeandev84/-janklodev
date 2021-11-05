<?php
namespace Jan\Component\Collection;


/**
 * class ArrayCollection
 * @package Jan\Component\Collection
*/
class ArrayCollection
{

       /**
        * @var array
       */
       protected $elements = [];



       /**
        * @param $element
        * @return bool
       */
       public function contains($element): bool
       {
            $name = $this->getObjectName($element);

            return \array_key_exists($name, $this->elements);
       }




       /**
        * @param $element
        * @return $this
       */
       public function add($element): ArrayCollection
       {
           return $this->factory($element, 'add');
       }


       /**
        * @param object $element
        * @return ArrayCollection
       */
       public function removeElement(object $element): ArrayCollection
       {
          return $this->factory($element, 'remove');
       }



       /**
        * @return array
       */
       public function getValues(): array
       {
           return array_values($this->elements);
       }


       /**
         * @param object $element
         * @param string $type
         * @return ArrayCollection
       */
       protected function factory(object $element, string $type): ArrayCollection
       {
             $elementName = (new \ReflectionObject($element))->getShortName();

             switch ($type) {
                 case 'add':
                     $this->elements[$elementName] = $element;
                 break;
                 case 'remove':
                     unset($this->elements[$elementName]);
                 break;
             }

             return $this;
       }



       /**
        * @param object $element
        * @return string
       */
       protected function getObjectShortName(object $element): string
       {
            return (new \ReflectionObject($element))->getShortName();
       }
}