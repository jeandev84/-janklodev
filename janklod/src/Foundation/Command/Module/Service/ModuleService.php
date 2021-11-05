<?php
namespace Jan\Foundation\Command\Module\Service;


use Jan\Foundation\Command\CommandStub;
use Jan\Foundation\Utils\Common;


/**
 * @package  Jan\Foundation\Command\Module\Service
*/
class ModuleService extends CommandStub
{

    /**
     * @param string|null $controllerName
     * @return array|string|string[]
     * @throws \Exception
     */
      public function generate(?string $controllerName)
      {
          $module = null;
          $cFilename = $controllerName;

          if (stripos($controllerName, '\\') !== false) {
              list($module, $controllerName) = explode('\\', $controllerName, 2);
              $cFilename = $module .'/'. $controllerName;
          }

          $stub = $this->replaceStub('controller', [
              'ControllerClass' => $controllerName,
              'ControllerNamespace' => Common::getControllerNamespace($module),
              'ControllerActions'   => ''
          ]);

          // TODO change path to controller and do it globally
          $targetPath = sprintf('app/Http/Controller/%s.php', $cFilename);
          $targetPath = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $targetPath);

          if ($this->fileSystem->exists($targetPath)) {
              throw new \Exception(
                  sprintf('Controller (%s) already exist!', $controllerName)
              );
          }

          $this->fileSystem->make($targetPath);
          $this->fileSystem->write($targetPath, $stub);

          return $targetPath;
      }
}