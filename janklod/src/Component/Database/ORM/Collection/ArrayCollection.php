<?php
namespace Jan\Component\Database\ORM\Collection;


/**
 * Class ArrayCollection
 *
 * @package Jan\Component\Database\ORM\Collection
*/
class ArrayCollection
{

    /**
     * @var array
    */
    protected $elements = [];


    /**
     * @param object $element
     * @return bool
     */
    public function contains(object $element): bool
    {
         return \in_array($element, $this->elements);
    }


    /**
     * @param object $element
     * @return ArrayCollection
    */
    public function add(object $element): ArrayCollection
    {
        $this->elements[] = $element;

        return $this;
    }




    /**
     * @param array $elements
    */
    public function collects(array $elements)
    {
         foreach ($elements as $element) {
             $this->add($element);
         }
    }





    /**
     * @param object $element
     * @return ArrayCollection
    */
    public function removeElement(object $element): ArrayCollection
    {

    }



    /**
     * @return array
     */
    public function getValues(): array
    {
        return array_values($this->elements);
    }
}