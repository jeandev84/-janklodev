<?php
namespace Jan\Foundation\Service;


use Jan\Component\FileSystem\FileSystem;
use Jan\Foundation\Generator\Exception\StubGeneratorException;



/**
 * Class Stub
 *
 * @package Jan\Foundation\Service
*/
class Stub
{

    /**
     * @var FileSystem
     */
    private $fileManager;



    /**
     * @param string $stubPath
     */
    public function __construct(string $stubPath)
    {
        $this->fileManager = new FileSystem($stubPath);
    }



    /**
     * @param $filename (filename of stub)
     *
     * Example : /stubs/controller.stub (name = controller)
     * @param $replacements
     * @return string|string[]
     */
    public function replaceStub($filename, $replacements)
    {
        return $this->fileManager->replace(
            sprintf('%s.stub', $filename),
            $replacements
        );
    }
}