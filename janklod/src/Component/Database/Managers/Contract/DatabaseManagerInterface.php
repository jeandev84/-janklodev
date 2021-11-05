<?php
namespace Jan\Component\Database\Managers\Contract;



/**
 * Class DatabaseManagerInterface
 *
 * @package Jan\Component\Database\Managers\Contract
*/
interface DatabaseManagerInterface
{
    /**
     * @return mixed
    */
    public function getConnection();


    /**
     * @return mixed
    */
    public function getConfigurations();
}