<?php

namespace Aditamairhamdev\MidtransCore;

use Illuminate\Support\ServiceProvider;

class MidtransCoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->publishes([
            __DIR__.'/config/midtranscore.php' => config_path('midtranscore.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/midtranscore.php', 'midtranscore'
        );
        $this->mergeConfigFrom(
            __DIR__.'/config/bank_list.php', 'bank_list'
        );
    }
}
