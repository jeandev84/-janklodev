<?php
namespace Jan\Foundation\Provider;


use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Component\Templating\Asset;


/**
 * Class AssetServiceProvider
 *
 * @package Jan\Foundation\Provider
*/
class AssetServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(Asset::class, function () {
            return new Asset('http://localhost:8000/');
        });
    }
}