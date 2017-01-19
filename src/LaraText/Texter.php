<?php

namespace LaraText;

use stdClass;
use LaraText\Exceptions\LaraTextException;
use LaraText\Exceptions\LaraTextReferenceException;
use LaraText\Contracts\Texter as TexterContract;

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
     * API authentication key
     *
     * @var  string  $authKey
     */
    protected $authKey;

    /**
     * Receiver will see this SenderID
     *
     * @var  string  $senderId
     */
    protected $senderId;

    /**
     * Which route does the message should be routed
     *
     * @var  string  $route
     */
    protected $route;

    /**
     * Set country to format your mobile numbers in international format
     *
     * @var  string  $country
     */
    protected $country;

    /**
     * Set default country to format your mobile numbers in international format
     *
     * @var  int  $defaultCountry
     */
    protected $defaultCountry;

    /**
     * Should I ignore India's Ndnc registry
     *
     * @var  string  $ignoreNdnc
     */
    protected $ignoreNdnc;

    /**
     * Set the campaign name
     *
     * @var  string  $campaign
     */
    protected $campaign;

    /**
     * Set the campaign name
     *
     * @var  string  $campaign
     */
    protected $prefixCountryCode;

    /**
     * Set the campaign name
     *
     * @var  string  $campaign
     */
    protected $formatMobileNumbers;

    /**
     * Set the campaign name
     *
     * @var  string  $campaign
     */
    protected $flashMessage;

    /**
     * Set the campaign name
     *
     * @var  string  $campaign
     */
    protected $unicodeMessage;

    /**
     * Set the campaign name
     *
     * @var  string  $campaign
     */
    protected $scheduledDateTime;

    /**
     * Set the campaign name
     *
     * @var  string  $campaign
     */
    protected $response;

    /**
     * Get an option value of the given key.
     *
     * @param  string  $key
     * @return object
     */
    public function __construct()
    {
        $gateway = config("text.gateway", "msg91");

        $this->apiUrl = config("text.$gateway.url", null);

        $this->authKey = config("text.$gateway.authKey", null);

        $this->senderId = config("text.$gateway.senderId", null);

        $this->route = config("text.$gateway.route", null);

        $this->country = config("text.$gateway.country", null);

        $this->defaultCountry = config("text.$gateway.defaultCountryCode", null);

        $this->flashMessage = null;

        $this->unicodeMessage = null;

        $this->ignoreNdnc = config("text.$gateway.ignoreNdnc", null);

        $this->campaign = config("text.$gateway.campaign", null);

        $this->prefixCountryCode = false;

        $this->formatMobileNumbers = false;

        $this->scheduledDateTime = null;

        $this->response = "json";
    }

    /**
     * Get an option value of the given key.
     *
     * @param  string  $key
     * @return object
     */
    public function get($key = null)
    {
        if ($key === null) {
            return $this->getAll();
        } else {
            if (is_string($key)) {
                if (property_exists($this, $key)) {
                    return $this->$key;
                } else {
                    throw new LaraTextReferenceException("Reference Error: Trying to obtain value of an unknown option \"$key\".", 1);
                }
            } else {
                $type = gettype($key);
                throw new LaraTextException("Incorrect Type: Argument 1 passed to Text::get() must be of the type string, but $type given.", 1);
            }
        }
    }

    protected function getAll()
    {
        return (object) get_object_vars($this);
    }

    /**
     * Get an option value of the given key.
     *
     * @param  string  $key
     * @return object
     */
    public function set($option, $value = null)
    {
        if ($value === null) {
            if ($option instanceof stdClass) {
                $this->setAll($option);
                return $this;
            } else if (is_array($option)) {
                $this->setAll($option);
                return $this;
            } else {
                $type = gettype($option);
                throw new LaraTextException("Incorrect Type: Argument 1 passed to Text::set() must be of the type stdClass object or an array, but $type given.", 1);
            }
        } else {
            if (is_string($option)) {
                if (property_exists($this, $option)) {
                    $this->validateOptions($option, $value);
                    return $this;
                } else {
                    throw new LaraTextReferenceException("Reference Error: Trying to set value to an unknown option \"$key\".", 1);
                }
            } else {
                $type = gettype($option);
                throw new LaraTextException("Expecting a string as option, but $type given.", 1);
            }
        }
    }

    /**
     * Get an option value of the given key.
     *
     * @param  string  $key
     * @return object
     */
    protected function setAll($options)
    {
        foreach ($options as $key => $value) {
            if (property_exists($this, $key)) {
                $this->validateOptions($key, $value);
            } else {
                throw new LaraTextReferenceException("Reference Error: Trying to set unknown option \"$key\" on LaraText.", 1);
            }
        }
    }

    protected function validateOptions($key, $value)
    {
        $type = gettype($value);

        switch ($key) {
            case 'message':
                if (is_string($value)) {
                    $this->$key = $value;
                } else {
                    throw new LaraTextException("Expecting a string as value of option \"$key\", but $type given.", 1);
                }
                break;

            case 'authKey':
                if (is_string($value)) {
                    $pattern = "/^[A-Za-z0-9]*$/";
                    if (preg_match($pattern, $value) === 1) {
                        $this->$key = $value;
                    } else {
                        throw new LaraTextException("Expecting a string of alphanumeric characters as value of option \"$key\".", 1);
                    }
                } else {
                    throw new LaraTextException("Expecting a string as value of option \"$key\", but $type given.", 1);
                }
                break;

            case 'country':
                if (is_int($value)) {
                    $this->$key = $value;
                } else {
                    throw new LaraTextException("Expecting an integer as value of option \"$key\", but $type given.", 1);
                }
                break;

            case 'prefixCountryCode':
                if (is_bool($value)) {
                    $this->$key = $value;
                } else {
                    throw new LaraTextException("Incorrect Type: Argument 1 passed to Text::set() must be of type boolean, but $type given.", 1);
                }
                break;
            
            default:
                $this->$key = $value;
                break;
        }
    }

    /**
     * Get an option value of the given key.
     *
     * @param  string  $key
     * @return object
     */
    public function to($to)
    {
        if ($to instanceof stdClass) {
            $this->formatMobileNumbers($to);
        } else if (is_array($to)) {
            $this->formatMobileNumbers($to);
        } else if (is_string($to)) {
            $list = explode(",", $to);
            $this->formatMobileNumbers($list);
        } else {
            $type = gettype($to);
            throw new LaraTextException("Incorrect Type: Argument 1 passed to Text::to() must be of the type stdClass object or an array or a comma seperated string, but $type given.", 1);
        }
        return $this;
    }

    protected function formatMobileNumbers($mobiles)
    {
        foreach ($mobiles as $key => $mobile) {

            $mobile = $this->removeSpaces($mobile);

            $mobile = $this->removeLeadingZero($mobile);

            $mobiles[$key] = $this->addCountryCode($mobile);
        }

        $this->to = implode(",", $mobiles);
    }

    protected function removeSpaces($mobile)
    {
        $pattern = "/\s*/";

        return preg_replace($pattern, "", $mobile);
    }

    protected function removeLeadingZero($mobile)
    {
        $pattern = "/^0{1}/";

        return preg_replace($pattern, "", $mobile);
    }

    protected function addCountryCode($mobile)
    {
        if ($this->prefixCountryCode) {
            if ($this->hasCountryCode($mobile)) {
                return $this->removeLeadingPlus($mobile);
            } else {
                if ($this->country !== null) {
                    return $this->country . $mobile;
                } else if ($this->defaultCountry !== null) {
                    return $this->defaultCountry . $mobile;
                } else {
                    throw new LaraTextException("Expecting atleast country or defaultCountry options not to be null.");
                }
            }
        } else {
            return $mobile;
        }
    }

    protected function hasCountryCode($mobile)
    {
        $pattern = "/^\+{1}/";

        return preg_match($pattern, $mobile) === 1;
    }

    protected function removeLeadingPlus($mobile)
    {
        $pattern = "/^\+{1}/";

        return preg_replace($pattern, "", $mobile);
    }

    public function prefixCountryCode($bool)
    {
        if (is_bool($bool)) {
            $this->prefixCountryCode = $bool;
        } else {
            $type = gettype($to);
            throw new LaraTextException("Incorrect Type: Argument 1 passed to Text::prefixCountryCode() must be of type boolean, but $type given.", 1);
        }
        return $this;
    }

    /**
     * Get an option value of the given key.
     *
     * @param  string  $key
     * @return object
     */
    public function send()
    {
        $textPostData = $this->makePostData();

        return $this->text($textPostData);
    }

    private function text($textPostData)
    {
        $curlHandle = curl_init($this->apiUrl);

        curl_setopt_array($curlHandle, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $textPostData,
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

    protected function makePostData()
    {
        if ($this->formatMobileNumbers) {

            $mobiles = explode(",", $this->to);

            foreach ($mobiles as $key => $mobile) {
                $mobile = $this->removeSpaces($mobile);

                $mobile = $this->removeLeadingZero($mobile);

                $mobile = $this->removeLeadingPlus($mobile);

                $mobiles[$key] = $mobile;
            }
            $this->to = implode(",", $mobiles);
        }
        $textPostData = [];

        if ($this->authKey !== null) {
            $textPostData["authkey"] = $this->authKey;
        } else {
            throw new LaraTextException("authKey cannot be null while texting a message", 1);
        }

        if ($this->to !== null) {
            $textPostData["mobiles"] = $this->to;
        } else {
            throw new LaraTextException("mobiles cannot be null while texting a message", 1);
        }

        if ($this->message !== null) {
            $textPostData["message"] = $this->message;
        } else {
            throw new LaraTextException("message cannot be null while texting a message", 1);
        }

        if ($this->senderId !== null) {
            $textPostData["sender"] = $this->senderId;
        } else {
            throw new LaraTextException("senderId cannot be null while texting a message", 1);
        }

        if ($this->route !== null) {
            $textPostData["route"] = $this->route;
        } else {
            throw new LaraTextException("route cannot be null while texting a message", 1);
        }

        if ($this->country !== null) {
            $textPostData["country"] = $this->country;
        }

        if ($this->flashMessage !== null) {
            if ($this->flashMessage) {
                $textPostData["flash"] = 1;
            } else {
                $textPostData["flash"] = 0;
            }
        }

        if ($this->unicodeMessage !== null) {
            if ($this->unicodeMessage) {
                $textPostData["unicode"] = 1;
            } else {
                $textPostData["unicode"] = 0;
            }
        }

        if ($this->ignoreNdnc !== null && $this->ignoreNdnc === true) {
            $textPostData["ignoreNdnc"] = 1;
        }

        if ($this->scheduledDateTime !== null) {
            $textPostData["schtime"] = $this->scheduledDateTime;
        }

        if ($this->response !== null) {
            $textPostData["response"] = $this->response;
        }

        return $textPostData;
    }

    public function message($message)
    {
        return $this->set("message", $message);
    }

    public function content($message)
    {
        return $this->set("message", $message);
    }
}
