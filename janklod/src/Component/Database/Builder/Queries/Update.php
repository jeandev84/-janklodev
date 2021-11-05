<?php
namespace Jan\Component\Database\Builder\Queries;

use Jan\Component\Database\Builder\SqlBuilder;


/**
 * Class Update
 *
 * @package Jan\Component\Database\Builder\Queries
*/
class Update extends SqlBuilder
{


    /**
     * @var array
    */
    protected $attributes = [];


    /**
     * @param array $attributes
    */
    public function __construct(array $attributes)
    {
         $this->attributes = array_keys($attributes);
    }




    /**
     * @return string
    */
    public function getName(): string
    {
        return 'update';
    }


    /**
     * @return string
    */
    public function buildSQL(): string
    {
       return sprintf('UPDATE %s SET %s', $this->table, $this->buildColumnAssigns($this->attributes));
    }


    /**
     * @return bool
    */
    public function isStart(): bool
    {
        return true;
    }


    /**
     * @param array $columns
     * @return string
    */
    protected function buildColumnAssigns(array $columns): string
    {
        $fields = [];

        foreach ($columns as $column) {
            array_push($fields, sprintf("%s = :%s", $column, $column));
        }

        return join(', ', $fields);
    }

}