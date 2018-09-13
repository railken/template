<?php

namespace Railken\Template;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class TemplateServiceProvider extends ServiceProvider
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    public $app;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->register(\TwigBridge\ServiceProvider::class);
        AliasLoader::getInstance()->alias('Twig', \TwigBridge\Facade\Twig::class);
    }
}
