<?php

namespace SanthoshKorukonda\LaraText;

use stdClass;
use SanthoshKorukonda\LaraText\Exceptions\LaraTextException;
use SanthoshKorukonda\LaraText\Exceptions\LaraTextReferenceException;
use SanthoshKorukonda\LaraText\Contracts\Texter as TexterContract;

class Texter implements TexterContract
{
    /**
     * Message to send.
     *
     * @var  string  $message
     */
    protected $message = null;

    /**
     * List of recipient addresses.
     *
     * @var  string  $to
     */
    protected $to;

    /**
     * API endpoint URL
     *
     * @var  string  $apiUrl
     */
    protected $apiUrl;

    /**
     * Get an option value of the given key.
     *
     * @param  string  $key
     * @return object
     */
    public function __construct(array $config = [])
    {        
        if (empty($config)) {

            $config = app("config")->get("text");

            $this->config = $this->makeConfig($config);

        } else {

            $this->config = $this->makeConfig($config);
        }
    }

    protected function makeConfig(array $config)
    {
        $gateway = $config["gateway"];

        if (empty($gateway)) {
            
            return [];

        } else {

            if (isset($config[$gateway])) {

                return $config[$gateway];

            } else {
                
                return [];
            }
        }
    }

    public function to($to)
    {
        if (is_array($to)) {

            $this->to = implode(",", $to);

        } else {

            $this->to = $to;
        }
        return $this;
    }

    public function send($textable)
    {
        $curlHandle = curl_init($this->apiUrl);

        curl_setopt_array($curlHandle, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $this->prepareFormData($textable),
            CURLOPT_RETURNTRANSFER => true
        ]);
        $curlOutput = curl_exec($curlHandle);

        $curlErrorNo = curl_errno($curlHandle);

        if ($curlErrorNo) {

            curl_close($curlHandle);

            throw new LaraTextException(curl_error($curlHandle), $curlErrorNo);
        }
        curl_close($curlHandle);

        return json_decode($curlOutput);
    }

    protected function prepareFormData($textable)
    {
        $textable = $textable->build();

        return [

            "authkey" => $textable->authKey(),

            "mobiles" => $this->to,

            "message" => $textable->content(),

            "sender" => $textable->from(),

            "route" => $textable->route(),

            "response" => "json"
        ];
    }

    public function failures()
    {
        # code...
    }
}
