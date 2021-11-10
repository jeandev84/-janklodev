<?php
namespace Jan\Component\Database\Migration\Support;


use Jan\Component\Database\Migration\Contract\MigrationInterface;


/**
 * Class Migration
 *
 * @package Jan\Component\Database\Migration\Support
*/
abstract class Migration implements MigrationInterface
{

    /**
     * @return string
    */
    public function getName(): string
    {
         return (new \ReflectionObject($this))->getShortName();
    }


    /**
     * @return false|string
    */
    public function getFileName()
    {
        return (new \ReflectionObject($this))->getFileName();
    }



    /**
     * Get attributes of migration table.
     *
     * @return array
    */
    abstract public function getAttributesToSave(): array;



    /**
     * @return mixed
    */
    abstract public function up();


    /**
     * @return mixed
    */
    abstract public function down();
}