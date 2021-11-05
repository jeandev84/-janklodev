<?php
namespace Jan\Foundation\Provider;

use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Component\Templating\Renderer;


/**
 * class ViewServiceProvider
 *
 * @package Jan\Foundation\Provider
*/
class ViewServiceProvider extends ServiceProvider
{

    /**
     * @return void
    */
    public function register()
    {
        $this->app->singleton('view', function () {
            $path = $this->app->get('path');
            return new Renderer($path. '/views');
        });
    }
}