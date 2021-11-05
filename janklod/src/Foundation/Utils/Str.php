<?php
namespace Jan\Foundation\Utils;


/**
 * Class Str
 *
 * @package Jan\Foundation\Utils
*/
class Str
{

    /**
     * @param string $input
     * @param string $separator
     * @return string
     */
     public static function toCamelCase(string $input, string $separator = '-'): string
     {
         $array = explode($separator, $input);

         $parts = array_map('ucwords', $array);

         return implode('', $parts);
     }


    /**
     * Sanitize input data
     * @param string $input
     * @return
     */
    public static function sanitize($input)
    {
        return htmlentities($input, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Transform name to CamelCase
     * @param string $name string for transform
     * @return string
     */
    public static function upperCamelCase(string $name): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }


    /**
     * Transform name to lowerCase
     * Ex: name => Name
     * @param string $name string for transform
     * @return string
    */
    public static function lowerCamelCase(string $name): string
    {
        return lcfirst(self::upperCamelCase($name));
    }
}