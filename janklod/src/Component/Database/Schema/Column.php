<?php
namespace Jan\Component\Database\Schema;


/**
 * Class Column
 *
 * @package Jan\Component\Database\Schema
*/
class Column
{

      const E_TYPES = ['INT', 'VARCHAR', 'TEXT', 'TINYINT'];


      /**
        * @var array
      */
      private $params = [
          'name'          => '',
          'type'          => '',
          'length'        => '',
          'default'       => '',
          'nullable'      => false,
          'autoincrement' => false,
          'index'         => 'primary',
          'collation'     => 'utf8_general_ci',
          'comments'      => []
      ];



      /**
        * @param array $params
      */
      public function __construct(array $params = [])
      {
           if ($params) {
              $this->setParams($params);
           }
      }



      /**
       * Determine if key param exist
       *
       * @param string $key
       * @return bool
      */
      public function exists(string $key): bool
      {
          return \array_key_exists($key, $this->params);
      }



      /**
       * Set param
       *
       * @param $key
       * @param $value
       * @return Column
      */
      public function setParam($key, $value): Column
      {
           if (! $this->exists($key)) {
               throw new \RuntimeException('Invalid column key param : '. $key);
           }

           $this->params[$key] = $value;

           return $this;
      }



      /**
       * Set params
       *
       * @param array $params
      */
      public function setParams(array $params)
      {
          foreach ($params as $key => $value) {
              $this->setParam($key, $value);
          }
      }




      /**
       * @param string $key
       * @param null $default
       * @return mixed|null
      */
      public function getParam(string $key, $default = null)
      {
          return $this->params[$key] ?? $default;
      }




      /**
       * @return array
      */
      public function getParams(): array
      {
          return $this->params;
      }




      /**
       * Set nullable column
       *
       * @return $this
      */
      public function nullable(): Column
      {
          return $this->setParam('nullable', true);
      }



      /**
       * add interphases
       * If $this->collation('utf8_unicode'),
       *
       * @param string $collation
       * @return Column
      */
      public function collation(string $collation): Column
      {
         return $this->setParam('collation', $collation);
      }



      /**
       * @param $comment
       * @return $this
      */
      public function comments($comment): Column
      {
          return $this->setParam('comments', $this->resolveComment($comment));
      }


      /**
       * @return mixed|null
      */
      public function getName()
      {
          return $this->getParam('name');
      }


      /**
       * @return mixed
      */
      public function getAutoincrement(): string
      {
         $autoincrement = $this->getParam('autoincrement');

         if($autoincrement === true) {
            return  'AUTO_INCREMENT';
         }

         return '';
      }



      /**
         * Get column type
         *
         * @return string
         *
         * TYPE(LENGTH)
      */
      public function getTypeAndLength(): string
      {
            $type = strtoupper($this->getParam('type'));

            if(in_array($type, self::E_TYPES)) {
                if($length = $this->getParam('length')) {
                    return sprintf('%s(%s)', $type, $length);
                }
                return $type;
            }

            return $type;
       }



      /**
       * @return string
      */
      public function getDefaultValue(): string
      {
          $default = $this->getParam('default');

          if($this->isNullable() && ! $default) {
              return 'DEFAULT NULL';
          }

          if($default) {
             return sprintf('DEFAULT "%s"', $default);
          }

          return 'NOT NULL';
      }



      /**
       * @return bool
      */
      public function isNullable(): bool
      {
          return $this->getParam('nullable') === true;
      }



       /**
        * @param $comment
        * @return string
       */
       protected function resolveComment($comment): string
       {
            return (string) (is_array($comment) ? join(', ', $comment) : $comment);
       }
}