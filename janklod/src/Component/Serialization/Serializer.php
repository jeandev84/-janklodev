<?php
namespace Jan\Component\Serialization;


use Exception;

/**
 * Class Serializer
 *
 * @package Jan\Component\Serialization
*/
class Serializer
{


    /**
     * @var array
    */
    protected static $cache = [];




    /**
     * @param $name
     * @param $context
     * @return void
    */
    public static function serialize($name, $context)
    {
        self::$cache[$name] = serialize($context);
    }




    /**
     * @param $name
     * @return bool
    */
    public static function serialised($name): bool
    {
        return isset(self::$cache[$name]);
    }



    /**
     * @param $name
     * @return mixed
     * @throws Exception
    */
    public static function deserialize($name)
    {
        if(! self::serialised($name)) {
            throw new Exception(sprintf('cannot be deserialized (%s)', $name));
        }

        return unserialize(self::$cache[$name]);
    }
}

/*
Example:
$user = new \App\Entity\User();
$user->setName('jean');
$user->setEmail('jeanyao@ymail.com');
$user->setPassword('secret');
Serializer::serialize('user.id', $user);
try {
    $context = Serializer::deserialize('user.id');
    dump($context);
} catch (\Exception $e) {
    dump($e->getMessage());
}
*/