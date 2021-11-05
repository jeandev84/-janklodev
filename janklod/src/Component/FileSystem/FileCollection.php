<?php
namespace Jan\Component\FileSystem;


/**
 * Class FileCollection
 *
 * @package Jan\Component\FileSystem
*/
class FileCollection
{


    /**
     * @var array
    */
    protected $files = [];



    /**
     * FileCollection constructor.
     *
     * @param array $files
    */
    public function __construct(array $files = [])
    {
          if ($files) {
              $this->setFiles($files);
          }
    }




    /**
     * add file
     *
     * @param string $path
     * @return $this
    */
    public function add(string $path): FileCollection
    {
        $this->files[] = new File($path);

        return $this;
    }



    /**
     * set files
     *
     * @param array $files
    */
    public function setFiles(array $files)
    {
        foreach ($files as $filename) {
            $this->add($filename);
        }
    }



    /**
     * get files
     *
     * @return array
    */
    public function getFiles(): array
    {
        return $this->files;
    }



    /**
     * remove files
     *
     * @return void
    */
    public function removeFiles()
    {
        foreach ($this->files as $file) {
            $this->removeFile($file);
        }
    }



    /**
     * @param File $file
    */
    public function removeFile(File $file)
    {
        @unlink($file->getPath());
    }
}