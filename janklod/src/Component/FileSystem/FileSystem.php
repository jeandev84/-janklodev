<?php
namespace Jan\Component\FileSystem;


/**
 * Class FileSystem
 *
 * @package Jan\Component\FileSystem
*/
class FileSystem extends FileLoader
{

    /**
     * @param string|null $resource
    */
    public function __construct(string $resource = null)
    {
        parent::__construct($resource);
    }



    /**
     * Write content into the file
     *
     * @param $filename
     * @param $content
     * @return false|int
     */
    public function write($filename, $content)
    {
        return file_put_contents($this->locate($filename), $content, FILE_APPEND);
    }




    /**
     * read file content
     *
     * @param $filename
     * @return false|string
    */
    public function read($filename)
    {
        return file_get_contents($this->locate($filename));
    }




    /**
     * uploading file
     *
     * @param $target
     * @param $filename
    */
    public function move($target, $filename)
    {
         move_uploaded_file($this->mkdir($target), $filename);
    }



    /**
     * @param $filename
     * @return File
     */
    public function info($filename): File
    {
        return new File($this->locate($filename));
    }


    /**
     * Create directory
     *
     * @param string $path
     * @return bool
    */
    public function mkdir(string $path): bool
    {
        $path = $this->locate($path);

        if(! \is_dir($path)) {
            return @mkdir($path, 0777, true);
        }

        return $path;
    }




    /**
     * Create a file
     *
     * @param string $filename
     * @return bool
    */
    public function make(string $filename): bool
    {
        $dirname = dirname($this->locate($filename));

        if(! \is_dir($dirname)) {
            @mkdir($dirname, 0777, true);
        }

        return touch($this->locate($filename));
    }




    /**
     * @param string $filename
     * @param string $base64
     * @return false|int
    */
    public function dumpFile(string $filename, string $base64)
    {
        $this->make($filename);
        
        return $this->write($filename, base64_decode($base64, true));
    }



    /**
     * @param string $filename
     * @param array $replacements
     * @return string|string[]
    */
    public function replace(string $filename, array $replacements)
    {
        $replaces = array_keys($replacements);

        return str_replace($replaces, $replacements, $this->read($filename));
    }



    /**
     * copy file to other destination
     *
     * @param string $from
     * @param string $destination
    */
    public function copy(string $from, string $destination)
    {
        // TODO implements
    }





    /**
     * @param $filename
     * @return bool
    */
    public function remove($filename): bool
    {
        if(! $this->exists($filename)) {
            return false;
        }

        return unlink($this->locate($filename));
    }



    /**
     * Remove files
     *
     * @param string $pattern
    */
    public function removeResources(string $pattern)
    {
        if($resources = $this->resources($pattern)) {
            array_map("unlink", $resources);
        }
    }
}