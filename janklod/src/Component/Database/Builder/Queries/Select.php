<?php
namespace Jan\Component\Database\Builder\Queries;

use Jan\Component\Database\Builder\SqlBuilder;


/**
 * class Insert
 *
 * @package Jan\Component\Database\Builder\Queries
 */
class Select extends SqlBuilder
{

    /**
     * @var string|array|null
    */
    protected $fields;


    /**
     * @param string|array $fields
    */
    public function __construct($fields = null)
    {
        $this->fields = $fields;
    }



    /**
     * @return string
    */
    public function getName(): string
    {
         return 'select';
    }


    /**
     * @return string
    */
    public function buildSQL(): string
    {
        $selects = $this->getSelectedFields($this->fields);
        return sprintf('SELECT %s', $selects);
    }


    /**
     * @return bool
    */
    public function isStart(): bool
    {
        return true;
    }


    /**
     * @param $fields
     * @return string
    */
    protected function getSelectedFields($fields): string
    {
        if (is_null($fields)) {

            if ($this->alias) {
                return sprintf('`%s`.* ', $this->alias);
            }

            return "* ";
        }

        if ($fields && \is_string($fields)) {
            $fields = explode(',', $fields);
        }

        if ($this->alias) {
            $c = [];
            foreach ($fields as $column) {
                $c[] = sprintf('`%s`.`%s`', $this->alias, trim($column));
            }

            return implode(', ', $c);
        }

        if (\is_array($fields)) {
            return implode(', ', $fields);
        }

        return $fields;
    }
}