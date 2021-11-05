<?php
namespace Jan\Component\Database\Builder;

/**
 *
 * @package Jan\Component\Database\Builder
*/
class SqlContextBuilder
{

      /**
       * @param array $sqlParts
       * @return string
      */
      public function make(array $sqlParts): string
      {
          $start = '';
          $parts = [];

          foreach ($sqlParts as $context) {

              if (! $context instanceof SqlExpression) {
                  if (\is_array($context)) {
                      foreach ($context as $c) {
                          $parts[] = $c->buildSQL();
                      }
                  }
              } else {
                  if ($context->isStart()) {
                      $start = $context->buildSQL();
                  }else{
                      $parts[] = $context->buildSQL();
                  }
              }
          }

          return sprintf('%s %s', $start, join(' ', $parts));
      }
}