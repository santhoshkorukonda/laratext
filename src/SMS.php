<?php

namespace SantoshKorukonda\SMS;

include_once 'CountryCodes.php';

use Exception;
use Carbon\Carbon;

class SMS
{
    public $url;
    public $authKey;
    public $gateway;
    public $senderId;
    public $route;
    public $country;
    public $ignoreNdnc;
    public $scheduledAt;
    public $campaign;
    public $message;
    public $to;
    private static $countryCode;

    /**
     * Initialize essential properties of this class
     * @param   No parameters
     * @return  No return[void]
     */
    public function __construct()
    {
        $this->gateway = config("sms.gateway", "msg91");
        $this->url = config("sms.$this->gateway.url");
        $this->authKey = config("sms.$this->gateway.authKey", null);        
        $this->senderId = config("sms.$this->gateway.senderId", null);
        $this->route = (int) config("sms.$this->gateway.route", null);
        $this->country = config("sms.$this->gateway.country", null);
        $this->ignoreNdnc = config("sms.$this->gateway.ignoreNdnc", 1);
        $this->campaign = config("sms.$this->gateway.campaign", null);
        $this->to = null;
        $this->message = null;
    }

    // Setting & getting option methods for sending SMS

    /**
     * Set options in bulk by reading array given by user
     * @param   array   $userOptions
     * @return  object  $this
     */
    public function setOptions(array $userOptions)
    {
        foreach ($userOptions as $key => $userOption) {
            if (property_exists($this, $key)) {
                $this->$key = $userOptions[$key];
            } else {
                throw new Exception("Unknown options given to process", 1);
            }
        }
        return $this;
    }

    /**
     * Return all the options in an object format
     * @param   No parameters
     * @return  object
     */
    public function getOptions()
    {
        return (object) [
            "gateway" => $this->gateway,
            "authKey" => $this->authKey,
            "senderId" => $this->senderId,
            "route" => $this->route,
            "country" => $this->country,
            "ignoreNdnc" => $this->ignoreNdnc,
            "scheduledAt" => $this->scheduledAt,
            "campaign" => $this->campaign
        ];
    }

    /**
     * Set an option and its value
     * @param   array   $userOptions
     * @return  object  $this
     */
    public function setOption(string $key, $value)
    {
        if (property_exists($this, $key)) {
            switch ($key) {
                case 'gateway':
                    if (is_string($value)) {
                        $this->$key = $value;
                        config(["sms.gateway" => $value]);
                    } else {
                        throw new Exception("Invalid gateway. Expecting a string.", 1);
                    }
                    break;
                case 'url':
                    if (is_string($value)) {
                        $this->$key = $value;
                        config(["sms.$this->gateway.$key" => $value]);
                    } else {
                        throw new Exception("Invalid url. Expecting a string.", 1);
                    }
                    break;
                case 'authKey':
                    if (is_string($value)) {
                        $this->$key = $value;
                        config(["sms.$this->gateway.$key" => $value]);
                    } else {
                        throw new Exception("Invalid authKey. Expecting a string.", 1);
                    }
                    break;
                case 'senderId':
                    $valueCount = strlen($value);
                    if (($valueCount > 0) && ($valueCount < 7)) {
                        if (is_string($value)) {
                            $this->$key = $value;
                            config(["sms.$this->gateway.$key" => $value]);
                        } else {
                            throw new Exception("Invalid senderId type. Expecting a string.", 1);
                        }
                    } else {
                        throw new Exception("Invalid senderId. value length should between 1 and 6.", 1);
                    }
                    break;
                case 'route':
                    if (is_int($value)) {
                        if (($value === 1) || ($value === 4)) {
                            $this->$key = $value;
                            config(["sms.$this->gateway.$key" => $value]);
                        } else {
                            throw new Exception("Invalid SMS route. Only 1 - Promotional and 4 - Transactional routes are available.", 1);
                        }
                    } else {
                        throw new Exception("Invalid SMS route. Expecting an integer.", 1);
                    }
                    break;
                case 'country':
                    if (defined($value)) {
                        self::$countryCode = $value;
                        if ($value === "IN") {
                            $this->$key = constant($value);
                            config(["sms.$this->gateway.$key" => constant($value)]);
                        } elseif ($value === "US") {
                            $this->$key = constant($value);
                            config(["sms.$this->gateway.$key" => constant($value)]);
                        } else {
                            $this->$key = 0;
                            config(["sms.$this->gateway.$key" => 0]);
                        }
                    } else {
                        throw new Exception("Invalid country code. Expecting a country code.", 1);
                    }
                    break;
                case 'ignoreNdnc':
                    if (is_int($value)) {
                        if ($value === 1) {
                            $this->$key = $value;
                            config(["sms.$this->gateway.$key" => $value]);
                        } else {
                            throw new Exception("Invalid ignoreNdnc. Only 1 is accepted.", 1);
                        }
                    } else {
                        throw new Exception("Invalid ignoreNdnc. Expecting an integer.", 1);
                    }
                    break;
                case 'scheduledAt':
                    try {
                        $this->scheduledAt = Carbon::parse($value)->format("Y-m-d h:i:s");
                    } catch (Exception $e) {
                        throw $e;
                    }
                    break;
                case 'campaign':
                    if (is_string($value)) {
                        $this->$key = $value;
                        config(["sms.$this->gateway.$key" => $value]);
                    } else {
                        throw new Exception("Invalid campaign. Expecting a string.", 1);
                    }
                    break;
                default:
                    throw new Exception("Unknown option given to process", 1);
                    break;
            }
        } else {
            throw new Exception("Unknown option given to process", 1);
        }
        return $this;
    }

    /**
     * Return an option value by the given key
     * @param   string   $key
     * @return  mixed
     */
    public function getOption(string $key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        } else {
            throw new Exception("Unknown option given to process", 1);
        }
    }

    /**
     * Set a route value by the given key
     * @param   int     $route
     * @return  object  $this
     */
    public function route(int $route)
    {
        return $this->setOption("route", $route);
    }

    /**
     * Set a country value by the given key
     * @param   string  $countryCode
     * @return  object  $this
     */
    public function country(string $countryCode)
    {
        return $this->setOption("country", $countryCode);
    }

    /**
     * Set sender mobiles list
     * @param   mixed   $mobiles
     * @return  object  $this
     */
    public function to($mobiles)
    {
        if (is_array($mobiles)) {
            if ($this->isMultiDimensional($mobiles)) {
                throw new Exception("Multi-dimensional array given. Expecting flat array.", 1);
            } else {
                foreach ($mobiles as $key => $mobile) {
                    if ($this->country === 0) {
                        $mobiles[$key] = constant(self::$countryCode) . $mobile;
                    } else {
                        $mobiles[$key] = $this->country . $mobile;
                    }
                }
                $this->to = implode(",", $mobiles);
                return $this;
            }
        } else {
            $this->to = $mobiles;
            return $this;
        }
    }

    /**
     * Set message given by the user
     * @param   string  $message
     * @return  object  $this
     */
    public function message(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set campaign name given by the user
     * @param   string  $name
     * @return  object  $this
     */
    public function campaign(string $name)
    {
        $this->campaign = $name;
        return $this;
    }

    /**
     * Set scheduled time given by the user
     * @param   string  $later
     * @return  object  $this
     */
    public function later(string $later)
    {
        $this->scheduledAt = Carbon::parse($later)->format("Y-m-d h:i:s");;
        return $this;
    }

    /**
     * Send message to the given list by the user
     * @param   No parameters
     * @return  object  $response
     */
    public function send()
    {
        $postData = $this->initializeDataToSend();
        return $this->sendMessage($postData);
    }

    /**
     * Check whether an array is multidimensional or not
     * @param   array   $array
     * @return  bool    true/false
     */
    public function sendUnicodeFlashMessage()
    {
        $postData = $this->initializeDataToSend();
        $postData["unicode"] = 1;
        $postData["flash"] = 1;
        return $this->sendMessage($postData);
    }

    /**
     * Check whether an array is multidimensional or not
     * @param   array   $array
     * @return  bool    true/false
     */
    public function sendUnicodeMessage()
    {
        $postData = $this->initializeDataToSend();
        $postData["unicode"] = 1;
        return $this->sendMessage($postData);
    }

    /**
     * Check whether an array is multidimensional or not
     * @param   array   $array
     * @return  bool    true/false
     */
    public function sendFlashMessage()
    {
        $postData = $this->initializeDataToSend();
        $postData["flash"] = 1;
        return $this->sendMessage($postData);
    }

    /**
     * Check whether an array is multidimensional or not
     * @param   array   $array
     * @return  bool    true/false
     */
    private function sendMessage($postData)
    {
        $curlHandle = curl_init($this->url);
        curl_setopt_array($curlHandle, [
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ]);
        $curlOutput = curl_exec($curlHandle);
        $curlErrorNo = curl_errno($curlHandle);
        if ($curlErrorNo) {
            curl_close($curlHandle);
            throw new Exception(curl_error($curlHandle), $curlErrorNo);
        }
        curl_close($curlHandle);
        return json_decode($curlOutput);
    }

    /**
     * Check whether an array is multidimensional or not
     * @param   array   $array
     * @return  bool    true/false
     */
    private function initializeDataToSend()
    {
        if (!$this->url) {
            throw new Exception("Set API url in config file or using setOption method.", 1);
        }

        if ($this->authKey) {
            $postData["authkey"] = $this->authKey;
        } else {
            throw new Exception("Set API authKey in config file or using setOption method.", 1);
        }

        if ($this->to) {
            $postData["mobiles"] = $this->to;
        } else {
            throw new Exception("Set mobile number before sending an SMS.", 1);
        }

        if ($this->message) {
            $postData["message"] = $this->message;
        } else {
            throw new Exception("Set a message before sending an SMS.", 1);
        }

        if ($this->senderId) {
            $postData["sender"] = $this->senderId;
        } else {
            throw new Exception("Set a senderId before sending an SMS.", 1);
        }

        if ($this->route) {
            $postData["route"] = $this->route;
        } else {
            throw new Exception("Set a route before sending an SMS.", 1);
        }

        if ($this->ignoreNdnc === 1) {
            $postData["ignoreNdnc"] = $this->ignoreNdnc;
        } else {
            throw new Exception("Invalid ignoreNdnc. Only 1 is accepted.", 1);
        }

        if ($this->country) {
            $postData["country"] = $this->country;
        }

        if ($this->scheduledAt) {
            $postData["schtime"] = $this->scheduledAt;
        }

        if ($this->scheduledAt) {
            $postData["schtime"] = $this->scheduledAt;
        }

        if ($this->campaign) {
            $postData["campaign"] = $this->campaign;
        }

        $postData["response"] = "json";

        return $postData;
    }

    /**
     * Check whether an array is multidimensional or not
     * @param   array   $array
     * @return  bool    true/false
     */
    private function isMultiDimensional(array $array): bool
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                return true;
            }
        }
        return false;
    }
}
