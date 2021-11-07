<?php
namespace Jan\Component\Database\Connection\PDO;


use Jan\Component\Database\Connection\Configuration;
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
     * @var PDO
    */
    protected $driver;




    /**
     * @param Configuration|null $config
    */
    public function __construct(Configuration $config = null)
    {
        parent::__construct($config);
    }




    /**
     * @param array $config
     * @return void
     * @throws \Exception
    */
    public function connect($config)
    {
        if (! $this->connected()) {

            $connection = $this->config['connection'];

            // make connection driver \PDO
            $pdo = $this->make($this->getDsn(), $this->getUsername(), $this->getPassword(), $this->config['options']);

            $this->setDriverConnection($pdo);
        }

        // dd($this);
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
    public function getDriverConnection(): PDO
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
     * @return PDO|null
    */
    public function make(string $dsn, string $username = null, string $password = null, array $options = []): ?PDO
    {
        try {

            $pdo = new PDO($dsn, $username, $password, $options);

            $options[] = sprintf("SET NAMES '%s'", $this->config->getCharset());

            foreach ($options as $option) {
                $pdo->exec($option);
            }

            $this->setDriverAttributes($pdo);

            return $pdo;

        } catch (\PDOException $e) {

            echo $e->getMessage();
        }

        return null;
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
     * @return string
    */
    protected function getDsn(): string
    {
        return sprintf('%s:host=%s;port=%s;dbname=%s;',
            $this->config->getTypeConnection(),
            $this->config->getHost(),
            $this->config->getPort(),
            $this->config->getDatabase()
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
         $statement = new Query($this->getDriverConnection());
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
     * @param PDO $pdo
    */
    protected function setDriverAttributes(PDO $pdo)
    {
        foreach ($this->getDriverAttributes() as $key => $value) {
            $pdo->setAttribute($key, $value);
        }
    }




    /**
     * @return array
    */
    protected function getDriverAttributes(): array
    {
        return [
            PDO::ATTR_PERSISTENT          => true, // permit to persist data in to database
            PDO::ATTR_EMULATE_PREPARES    => 0,
            PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION
        ];
    }



    /**
     * @return array
    */
    protected function getDefaultOptions(): array
    {
        return [];
    }
}