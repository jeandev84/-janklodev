<?php
namespace Jan\Component\Http\Request;


use Jan\Component\Http\Bag\ParameterBag;


/**
 *
*/
class Body extends ParameterBag
{

     /**
      * @return array
     */
     public function toArray(): array
     {
         return $this->all();
     }


     /**
      * @return false|string
     */
     public function toJson()
     {
         return \json_encode($this->toArray());
     }
}