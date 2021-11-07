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
    protected $createdAt;


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
    public function setCreatedAt(\DateTime $date)
    {
        $this->createdAt = $date->format('Y-m-d H:i:s');
    }



    /**
     * @return string
    */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }



    /**
     * @return false|string
    */
    public function getFileName()
    {
        return (new \ReflectionObject($this))->getFileName();
    }


    
    
    /**
     * @return string[]
    */
    public function getAttributes(): array
    {
        return [
            'version'     => (new \ReflectionObject($this))->getShortName(),
            'executed_at' => $this->getCreatedAt()
        ];
    }
}