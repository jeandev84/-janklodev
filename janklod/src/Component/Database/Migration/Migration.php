<?php
namespace Jan\Component\Database\Migration;


use Jan\Component\Database\Migration\Contract\MigrationInterface;


/**
 * Class Migration
 *
 * @package Jan\Component\Database\Migration
*/
abstract class Migration implements MigrationInterface
{

    /**
     * @var string
    */
    protected $executedAt;


    /**
     * @return mixed
    */
    abstract public function up();


    /**
     * @return mixed
    */
    abstract public function down();


    /**
     * @return string
    */
    public function getName(): string
    {
        return (new \ReflectionObject($this))->getShortName();
    }



    /**
     * @param \DateTime $date
    */
    public function setExecutedAt(\DateTime $date)
    {
        $this->executedAt = $date->format('Y-m-d H:i:s');
    }


    /**
     * @return string
    */
    public function getExecutedAt(): string
    {
        return $this->executedAt;
    }



    /**
     * @return false|string
    */
    public function getFileName()
    {
        return (new \ReflectionObject($this))->getFileName();
    }
}