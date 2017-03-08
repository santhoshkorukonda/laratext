<?php

namespace SanthoshKorukonda\LaraText;

use stdClass;
use SanthoshKorukonda\LaraText\Exceptions\LaraTextException;
use SanthoshKorukonda\LaraText\Exceptions\LaraTextReferenceException;
use SanthoshKorukonda\LaraText\Contracts\Textable as TextableContract;

class Textable implements TextableContract
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

        $this->route = (int) config("text.$gateway.route", null);

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

    public function from(string $senderId = null)
    {
        if ($senderId) {

            $this->senderId = $senderId;

            return $this;

        } else {

            return $this->senderId;
        }
    }

    public function content(string $message = null)
    {
        if ($message) {

            $this->message = $message;

            return $this;
        } else {

            return $this->message;
        }
    }

    public function route(int $route = null)
    {
        if ($route) {

            $this->route = $route;

            return $this;

        } else {

            $this->route;
        }
    }

    public function authKey(string $authKey = null)
    {
        if ($authKey) {

            $this->authKey = $authKey;

            return $this;

        } else {

            return $this->authKey;
        }
    }
}
