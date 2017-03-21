<?php

namespace SanthoshKorukonda\LaraText;

use Illuminate\Support\Arr;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Manager;
use GuzzleHttp\Client as HttpClient;
use SanthoshKorukonda\LaraText\Transport\LogTransport;
use SanthoshKorukonda\LaraText\Transport\ArrayTransport;
use SanthoshKorukonda\LaraText\Transport\Msg91Transport;

class TransportManager extends Manager
{
    /**
     * Create an instance of the Msg91 Transport driver.
     *
     * @return \SanthoshKorukonda\LaraText\Transport\Msg91Transport
     */
    protected function createMsg91Driver()
    {
        $config = $this->app['config']->get('services.msg91', []);

        return new Msg91Transport(
            $this->guzzle($config), $config['secret'], Arr::get($config, 'options', [])
        );
    }

    /**
     * Create an instance of the Log Swift Transport driver.
     *
     * @return \Illuminate\Mail\Transport\LogTransport
     */
    protected function createLogDriver()
    {
        return new LogTransport($this->app->make(LoggerInterface::class));
    }

    /**
     * Create an instance of the Array Swift Transport Driver.
     *
     * @return \Illuminate\Mail\Transport\ArrayTransport
     */
    protected function createArrayDriver()
    {
        return new ArrayTransport;
    }

    /**
     * Get a fresh Guzzle HTTP client instance.
     *
     * @param  array  $config
     * @return \GuzzleHttp\Client
     */
    protected function guzzle($config)
    {
        return new HttpClient(Arr::add(
            Arr::get($config, 'guzzle', []), 'connect_timeout', 60
        ));
    }

    /**
     * Get the default text driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['text.driver'];
    }

    /**
     * Set the default mail driver name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultDriver(string $name)
    {
        $this->app['config']['text.driver'] = $name;
    }
}
