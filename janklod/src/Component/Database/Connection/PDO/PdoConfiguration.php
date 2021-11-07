<?php
namespace Jan\Component\Database\Connection\PDO;


use Jan\Component\Database\Connection\Configuration;



/**
 * Class PdoConfiguration
 *
 * @package Jan\Component\Database\PDO
*/
class PdoConfiguration extends Configuration
{

    const DRIVER        = 'driver';
    const HOST          = 'host';
    const DATABASE      = 'database';
    const PORT          = 'port';
    const CHARSET       = 'charset';
    const USERNAME      = 'username';
    const PASSWORD      = 'password';
    const COLLATION     = 'collation';
    const OPTIONS       = 'options';
    const PREFIX        = 'prefix';
    const ENGINE        = 'engine';


    /**
     * @var array
    */
    protected $params = [
        self::DRIVER     => 'mysql',
        self::DATABASE       => 'default',
        self::HOST           => '127.0.0.1',
        self::PORT           => '3306',
        self::CHARSET        => 'utf8',
        self::USERNAME       => 'root',
        self::PASSWORD       => '',
        self::COLLATION      => 'utf8_unicode_ci',
        self::OPTIONS        => [],
        self::PREFIX         => '',
        self::ENGINE         => 'InnoDB', // InnoDB or MyISAM
    ];



    /**
     * @return mixed|null
    */
    public function getTypeConnection()
    {
        return $this->get(self::DRIVER);
    }



    /**
     * @return mixed|null
     */
    public function getHost()
    {
        return $this->get(self::HOST);
    }



    /**
     * @return mixed|null
    */
    public function getDatabase()
    {
        return $this->get(self::DATABASE);
    }


    /**
     * @return mixed|null
    */
    public function getPort()
    {
        return $this->get(self::PORT);
    }


    /**
     * @return mixed|null
    */
    public function getCharset()
    {
        return $this->get(self::CHARSET);
    }


    /**
     * @return mixed|null
    */
    public function getUsername()
    {
        return $this->get(self::USERNAME);
    }


    /**
     * @return mixed|null
     */
    public function getPassword()
    {
        return $this->get(self::PASSWORD);
    }


    /**
     * @return mixed|null
     */
    public function getOptions()
    {
        return $this->get(self::OPTIONS);
    }


    /**
     * @return mixed|null
     */
    public function getCollation()
    {
        return $this->get(self::COLLATION);
    }


    /**
     * @return mixed|null
    */
    public function getPrefix()
    {
        return $this->get(self::PREFIX);
    }




    /**
     * @return mixed|null
    */
    public function getEngine()
    {
        return $this->get(self::ENGINE);
    }




    /**
     * @return mixed|null
    */
    public function getTablePrefix()
    {
        return $this->get(self::PREFIX);
    }
}