<?php

namespace LaraText\Bootstrap;

use LaraText\Texter;

use Illuminate\Support\ServiceProvider;

class TextServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'../Config/text.php' => config_path('text.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton("laratext.texter", function ($app) {
            return new Texter();
        });
    }
}
