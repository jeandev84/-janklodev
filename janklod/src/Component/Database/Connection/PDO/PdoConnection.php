<?php
namespace Jan\Component\Database\Connection\PDO;


use Jan\Component\Database\Connection\Connection;
use Jan\Component\Database\Connection\Contract\QueryInterface;
use Jan\Component\Database\Connection\Exception\ConnectionException;
use Jan\Component\Database\Connection\Exception\DriverException;
use PDO;


/**
 * Class PdoConnection
 *
 * @package Jan\Component\Database\Connection\PDO
*/
class PdoConnection extends Connection
{

    /**
     * @var array
    */
    protected $options = [
        PDO::ATTR_PERSISTENT => true, // permit to persist data in to database
        PDO::ATTR_EMULATE_PREPARES => 0,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ];






    /**
     * @param array $config
     * @return void
     * @throws \Exception
    */
    public function connect($config)
    {
        parent::connect($config);

        if (! $this->connected()) {

            $driver = $this->config['driver'];

            if (! $this->availableDrivers($driver)) {
                throw new DriverException(sprintf('enabled driver (%s) for connection to database.', $driver));
            }


            // make connection driver \PDO
            $pdo = $this->make($this->getDsn($driver), $this->getUsername(), $this->getPassword(), $this->getOptions());

            $this->setDriver($pdo);
        }
    }



    /**
     * @return bool
     */
    public function connected(): bool
    {
        return $this->driver instanceof PDO;
    }



    /**
     * @return PDO
     * @throws ConnectionException
    */
    public function getDriver(): PDO
    {
        if (! $this->connected()) {
            throw new ConnectionException('Unavailable PDO driver, please try to connect to the database.');
        }

        return $this->driver;
    }




    /**
     * @param string $dsn
     * @param string|null $username
     * @param string|null $password
     * @param array|null $options
     * @return PDO
    */
    public function make(string $dsn, string $username = null, string $password = null, array $options = null): PDO
    {
        return new PDO($dsn, $username, $password, $options);
    }



    /**
     * Disconnection to the database
    */
    public function disconnect()
    {
        $this->driver = null;
    }




    /**
     * @param $driver
     * @return bool
    */
    protected function availableDrivers($driver): bool
    {
        return \in_array($driver, \PDO::getAvailableDrivers());
    }



    /**
     * @param string $driver
     * @return string
    */
    protected function getDsn(string $driver): string
    {
        return sprintf('%s:host=%s;port=%s;dbname=%s;',
            $driver,
            $this->config['host'],
            $this->config['port'],
            $this->config['database']
        );
    }


    /**
     * @param string $sql
     * @param array $params
     * @param array $options
     * @return QueryInterface
     * @throws ConnectionException
     */
    public function query(string $sql, array $params = [], array $options = []): QueryInterface
    {
         $statement = new Query($this->getDriver());
         $statement->query($sql)
                   ->params($params);

         if (isset($options['referenceClass'])) {
             $statement->metaClass($options['referenceClass']);
         }


         return $statement;
    }



    /**
     * @param string $sql
    */
    public function exec(string $sql)
    {
        $this->driver->exec($sql);
    }




    /**
     * Get options
     *
     * @return array
    */
    protected function getOptions(): array
    {
        return array_merge($this->options, $this->config['options'] ?? []);
    }




    /**
     * @return mixed|null
    */
    protected function getUsername()
    {
        return $this->config['username'];
    }


    /**
     * @return mixed|null
    */
    protected function getPassword()
    {
        return $this->config['password'];
    }
}