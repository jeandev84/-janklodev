<?php
namespace Jan\Component\Database\ORM\Contract;


/**
 * Interface ObjectManagerInterface
 *
 * @package Jan\Component\Database\ORM\Contract
*/
interface ObjectManagerInterface
{

    /**
     * prepare object to persist (save object params)
     *
     * @param object $object
     * @return mixed
    */
    public function persist(object $object);



    /**
     * prepare object to remove
     *
     * @param object $object
     * @return mixed
    */
    public function remove(object $object);

}