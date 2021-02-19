<?php

namespace sahifedp\MenuManager;

use Illuminate\Support\ServiceProvider;
use sahifedp\MenuManager\Views\Components\Show\Show;

class MenuManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'menu');
        $this->loadViewComponentsAs('menu', [
            Show::class
        ]);
    }
}
