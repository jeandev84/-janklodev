<?php
namespace Jan\Component\Database\Builder\Queries;


use Jan\Component\Database\Builder\SqlBuilder;

/**
 * Class Delete
 *
 * @package Jan\Component\Database\Builder\Queries
*/
class Delete extends SqlBuilder
{

    /**
     * @var string
    */
    protected $table;


    /**
     * @param string $table
    */
    public function __construct(string $table)
    {
        $this->table = $table;
    }




    /**
     * @return string
    */
    public function getName(): string
    {
        return 'delete';
    }



    /**
     * @return string
    */
    public function buildSQL(): string
    {
        return sprintf('DELETE FROM %s', $this->table);
    }



    public function isStart(): bool
    {
        return true;
    }
}