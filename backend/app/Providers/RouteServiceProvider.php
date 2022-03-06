<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['router']->group([
            'namespace' => 'App\Http\Controllers',
        ], function ($router) {
            require base_path('routes/web.php');
        });

        $this->app['router']->group([
            'namespace' => 'App\Http\Controllers',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }
}
