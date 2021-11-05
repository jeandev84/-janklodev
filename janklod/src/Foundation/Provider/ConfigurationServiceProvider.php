<?php
namespace Jan\Foundation\Provider;


use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Component\Config\Config;
use Jan\Component\FileSystem\FileSystem;
use Jan\Component\Config\Loaders\ArrayLoader;



/**
 * Class ConfigurationServiceProvider
 * @package Jan\Foundation\Providers
 */
class ConfigurationServiceProvider extends ServiceProvider
{


    /**
     * @return void
     * @throws \Exception
    */
    public function register()
    {
        $this->app->singleton(Config::class, function (FileSystem $fs) {

            $config = new Config();
            $config->load([
                $this->makeArrayLoader($fs),
                // json loader
                // xml loader
                //..
            ]);

            return $config;
        });
    }




    /**
     * @param FileSystem $fs
     * @return ArrayLoader
    */
    protected function makeArrayLoader(FileSystem $fs): ArrayLoader
    {
        $resources = $fs->resources('/config/*.php');
        $data = [];

        foreach ($resources as $resource) {
            $filename = pathinfo($resource)['filename'];
            $data[$filename] = $resource;
        }

        return new ArrayLoader($data);
    }


    protected function makeJsonLoader()
    {
        //
    }


    protected function makeXmlLoader()
    {
        //
    }
}