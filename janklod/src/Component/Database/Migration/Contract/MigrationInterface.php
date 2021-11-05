<?php
namespace Jan\Component\Database\Migration\Contract;


/**
 * Interface MigrationInterface
*/
interface MigrationInterface
{
    /**
     * @return mixed
    */
    public function up();


    /**
     * @return mixed
    */
    public function down();
}