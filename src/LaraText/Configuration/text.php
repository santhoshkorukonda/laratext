<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SMS Driver
    |--------------------------------------------------------------------------
    |
    | LaraText supports texting as drivers for sending of SMS. You may specify
    | which one you're using throughout your application here. By default,
    | LaraText is setup for msg91.
    |
    | Supported: "msg91"
    |
    */

    "driver" => env("SMS_DRIVER", "msg91"),

    /*
    |--------------------------------------------------------------------------
    | SMS API Endpoint
    |--------------------------------------------------------------------------
    |
    | Here you may provide the API Endpoint address of the SMS server used
    | by your applications. A default option is provided that is compatible with
    | the Msg91 SMS service which will provide reliable deliveries.
    |
    */

    "endpoint" => env("SMS_API_ENDPOINT"),

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address => SenderId
    |--------------------------------------------------------------------------
    |
    | You may wish for all texts sent by your application to be sent from
    | the same address. Here, you may specify an Id that is used globally for
    | all texts that are sent by your application.
    |
    */

    'from' => env("SMS_SENDER_ID"),

    /*
    |--------------------------------------------------------------------------
    | Country Settings
    |--------------------------------------------------------------------------
    |
    | If you are sending any international texts, you may configure your
    | country settings here, allowing you to customize the country prefixing
    | of the texts. Or, you may simply stick with the LaraText defaults!
    |
    */

    "country" => [

        "default" => env("SMS_DEFAULT_COUNTRY", 91),

        "autoPrefix" => env("SMS_AUTO_PREFIX", false)
    ]
];
