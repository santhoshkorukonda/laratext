<?php

return [
    "gateway" => env("SMS_GATEWAY", "msg91"),
    "msg91" => [
        "url" => env("SMS_API_URL"),
        "authKey" => env("SMS_AUTH_KEY"),
        "senderId" => env("SMS_SENDER_ID"),
        "route" => env("SMS_ROUTE"),
        "country" => env("SMS_COUNTRY", null)
    ]
];
