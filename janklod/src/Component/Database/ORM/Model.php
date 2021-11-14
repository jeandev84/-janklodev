<?php
namespace Jan\Component\Database\ORM;


use Jan\Component\Database\Managers\Capsule;
use Jan\Component\Database\ORM\Record\ActiveRecord;



/**
 * Class Model
 *
 * @package Jan\Component\Database\ORM
*/
abstract class Model extends ActiveRecord
{

    /**
     * @throws \Exception
    */
    public function __construct()
    {
        $em = Capsule::instance()->getEntityManager();

        parent::__construct($em);
    }


    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
    */
    public static function __callStatic($name, $arguments)
    {
        if (! method_exists(new static(), $name)) {
            throw new \Exception();
        }

        return (new static())->{$name}(...$arguments);
    }
}