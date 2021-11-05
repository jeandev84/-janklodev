<?php
namespace Jan\Foundation;

/**
 * Class ServerLocal
 *
 * @package Jan\Foundation
 *
 * TODO Fix bug
*/
class ServerLocal
{


    /** @var string */
    private $scriptName;



    /**
     * Server constructor.
     * @param string $scriptName [ ex: script file ./basePath/public/index.php ]
     */
    public function __construct(string $scriptName)
    {
        $this->scriptName = rtrim($scriptName, '/');
        $_SERVER['SCRIPT_NAME'] = '/index.php';
    }


    /**
     * @param string $uri
     * @return bool
    */
    public function run(string $uri): bool
    {
        $url = parse_url($uri, PHP_URL_PATH);

        if(strpos($url, '/') === false) {
            $url .= '/';
        }

        $directory = dirname($this->scriptName);

        if ($url !== '/' && file_exists($directory.$url)) {
            return false;
        }

        return require_once realpath($this->scriptName);
    }
}