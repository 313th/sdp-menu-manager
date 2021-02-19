<?php

namespace packages\sahifedp\MenuManager;

use Illuminate\Support\ServiceProvider;

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
        $this->loadViewComponentsAs('menu', [
            Show::class
        ]);
    }
}
