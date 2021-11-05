<?php
namespace Jan\Foundation\Command;



use Jan\Component\FileSystem\FileSystem;
use Jan\Foundation\Service\Stub;


/**
 * Class CommandStub
 *
 * @package Jan\Foundation\Command
*/
abstract class CommandStub extends Stub
{

    /**
     * @var FileSystem
    */
    protected $fileSystem;



    /**
     * CommonGenerator
     *
     * @param FileSystem $fileSystem
    */
    public function __construct(FileSystem $fileSystem)
    {
        parent::__construct($this->getStubPath());

        $this->fileSystem = $fileSystem;
    }



    /**
     * @return string
    */
    protected function getStubPath(): string
    {
        return __DIR__ . '/stubs';
    }
}