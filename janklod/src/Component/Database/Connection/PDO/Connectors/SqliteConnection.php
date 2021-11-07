<?php
namespace Jan\Component\Database\Connection\PDO\Connectors;


use Jan\Component\Database\Connection\PDO\PdoConnection;



/**
 * Class SqliteConnection
 *
 * @package Jan\Component\Database\Connection\PDO\Connectors
*/
class SqliteConnection extends PdoConnection
{

      /**
       * @return null
      */
      protected function getUsername()
      {
          return null;
      }


      /**
       * @return null
      */
      protected function getPassword()
      {
          return null;
      }




      /**
       * @return string
      */
      protected function getDsn(): string
      {
          return sprintf('%s:%s', $this->config->getTypeConnection(), $this->config->getDatabase());
      }



      /**
       * @return string
      */
      public function getName(): string
      {
          return 'sqlite';
      }
}