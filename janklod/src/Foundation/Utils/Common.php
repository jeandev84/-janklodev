<?php
namespace Jan\Foundation\Utils;

class Common
{

    /**
     * @param string|null $moduleNamespace
     * @return string
    */
    public static function getControllerNamespace(string $moduleNamespace = null): string
    {
         $ns = "App\\Http\\Controller";

         if ($moduleNamespace) {
             $ns .= "\\{$moduleNamespace}";
         }

         return $ns;
    }
}