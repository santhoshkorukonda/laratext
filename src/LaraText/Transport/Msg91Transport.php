<?php

namespace SanthoshKorukonda\LaraText\Transport;

use GuzzleHttp\ClientInterface;
use SanthoshKorukonda\LaraText\Message;
use SanthoshKorukonda\LaraText\Contracts\Transport;

class Msg91Transport implements Transport
{
    /**
     * Guzzle client instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * The SparkPost API key.
     *
     * @var string
     */
    protected $key;

    /**
     * Transmission options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Create a new SparkPost transport instance.
     *
     * @param  \GuzzleHttp\ClientInterface  $client
     * @param  string  $key
     * @param  array  $options
     * @return void
     */
    public function __construct(ClientInterface $client, $key, $options = [])
    {
        $this->key = $key;
        $this->client = $client;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Message $message)
    {
        $response = $this->client->post('https://api.msg91.com/api/sendhttp.php', [
            'form_params' => array_merge([
                "authkey" => $this->getKey(),
                'mobiles' => $message->to(),
                'message' => $message->content(),
                'sender' => $message->from(),
                'route' => $message->route(),
                'response' => 'json'
            ], $message->options())
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Get the API key being used by the transport.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set the API key being used by the transport.
     *
     * @param  string  $key
     * @return string
     */
    public function setKey($key)
    {
        return $this->key = $key;
    }

    /**
     * Get the transmission options being used by the transport.
     *
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the transmission options being used by the transport.
     *
     * @param  array  $options
     * @return array
     */
    public function setOptions(array $options)
    {
        return $this->options = $options;
    }
}
