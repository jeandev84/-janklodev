<?php
namespace Jan\Component\Http\Bag;


/**
 * class HeaderBag
 * @package Jan\Component\Http\Bag
*/
class HeaderBag extends ParameterBag
{
     public function set(string $key, $value): ParameterBag
     {
         // $key = str_replace('-', '_', strtoupper($key));
         return parent::set($key, $value);
     }
}