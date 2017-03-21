<?php

namespace SanthoshKorukonda\LaraText\Bootstrap;

use SanthoshKorukonda\LaraText\Texter;
use Illuminate\Support\ServiceProvider;
use SanthoshKorukonda\LaraText\TransportManager;
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
        $this->registerTexterTransport();

        $this->app->singleton(TexterContract::class, function ($app) {

            $transport = $app["texter.transport"];

            return new Texter($transport->driver());
        });
        $this->app->alias(TexterContract::class, "texter");
    }

    /**
     * Register the Texter Transport instance.
     *
     * @return void
     */
    protected function registerTexterTransport()
    {
        $this->app->singleton("texter.transport", function ($app) {
            
            return new TransportManager($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [TexterContract::class, "texter"];
    }
}
