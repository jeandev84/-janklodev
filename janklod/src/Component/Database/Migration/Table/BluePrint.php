<?php
namespace Jan\Component\Database\Migration\Table;


/**
 * Class BluePrint
 *
 * @package Jan\Component\Database\Migration\Table
*/
class BluePrint
{

    const __SPACE__ = ' ';


    /**
     * @var string
    */
    protected $table;



    /**
     * @var string
    */
    protected $primary;



    /**
     * @var array
    */
    protected $columns = [];




    /**
     * @param string $table
    */
    public function __construct(string $table)
    {
         $this->table = $table;
    }


    /**
     * @param string $name
     * @param string $type
     * @param int $length
     * @param null $default
     * @param false $autoincrement
     * @return Column
    */
    public function addColumn(string $name, string $type, int $length = 11, $default = null, bool $autoincrement = false): Column
    {
        $column = new Column(
            compact('name', 'type', 'length', 'default', 'autoincrement')
        );

        if ($autoincrement) {
            $this->primary = $name;
        }

        return $this->columns[$name] = $column;
    }




    /**
     * @return string
    */
    public function getPrimaryKey(): string
    {
        return $this->primary;
    }



    /**
     * @param $name
     * @return Column
     * @throws Exception
    */
    public function increments($name): Column
    {
        return $this->addColumn($name, 'INT', 11, null, true);
    }



    /**
     * @param $name
     * @param int $length
     * @return Column
     * @throws Exception
     */
    public function integer($name, $length = 11): Column
    {
        return $this->addColumn($name, 'INT', $length);
    }


    /**
     * @param string $name
     * @param int $length
     * @return Column
     * @throws Exception
    */
    public function string(string $name, int $length = 255): Column
    {
        return $this->addColumn($name, 'VARCHAR', $length);
    }


    /**
     * @param $name
     * @return Column
     * @throws Exception
    */
    public function boolean($name): Column
    {
        return $this->addColumn($name, 'TINYINT', 1, 0);
    }


    /**
     * @param $name
     * @return Column
     * @throws Exception
     */
    public function text($name): Column
    {
        return $this->addColumn($name, 'TEXT', false);
    }


    /**
     * @param $name
     * @return Column
     * @throws Exception
    */
    public function datetime($name): Column
    {
        return $this->addColumn($name, 'DATETIME', false);
    }



    /**
     * @throws Exception
    */
    public function timestamps()
    {
        $this->datetime('created_at');
        $this->datetime('updated_at');
    }


    /**
     * @param bool $status
     * @throws Exception
    */
    public function softDeletes(bool $status = false)
    {
        if($status) {
            $this->boolean('deleted_at');
        }
    }



    /**
     * @return array
    */
    public function getColumns(): array
    {
        return $this->columns;
    }



    /**
     * @return string
    */
    public function getConstraintColumns(): string
    {
        $sql = [];
        $nbrColumns = count($this->columns);
        $i = 0;

        /** @var Column $column */
        if (! empty($this->columns)) {
             foreach ($this->columns as $column) {
                 $sql[] = sprintf('`%s`%s', $column->getName(), self::__SPACE__);
                 $sql[] = sprintf('%s%s', $column->getTypeAndLength(), self::__SPACE__);
                 $sql[] = $column->getDefaultValue();

                 if ($autoincrement = $column->getAutoincrement()) {
                     $sql[] = self::__SPACE__. $autoincrement;
                 }

                 ++$i;

                 if ($i < $nbrColumns) {
                     $sql[] = ','. self::__SPACE__;
                 }
             }
        }

        $str = implode($sql);

        if ($primaryKey = $this->getPrimaryKey()) {
            $str .= sprintf(', PRIMARY KEY(`%s`)', $primaryKey);
        }

        return $str;
    }




   /**
    * @return array
   */
   public function getColumnToAltered(): array
   {
        return [];
   }
}