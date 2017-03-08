<?php

namespace LaraText\Bootstrap;

use SanthoshKorukonda\LaraText\Texter;
use Illuminate\Support\ServiceProvider;
use SanthoshKorukonda\LaraText\Console\TextMakeCommand;
use SanthoshKorukonda\LaraText\Contracts\Texter as TexterContract;

class TextServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var  bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return  void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../Configuration/text.php' => config_path('text.php'),
        ]);

        if ($this->app->runningInConsole()) {

            $this->commands([
                TextMakeCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TexterContract::class, function ($app) {

            $config = $app->make('config')->get('text');

            return new Texter($config);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ["texter"];
    }
}
