<?php
namespace Jan\Foundation\Provider;

use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Foundation\Generator\UrlGenerator;


/**
 * Class UrlGeneratorServiceProvider
 *
 * @package Jan\Foundation\Provider
*/
class UrlGeneratorServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(UrlGenerator::class, function () {
            // new UrlGenerator(null, null);
        });
    }
}