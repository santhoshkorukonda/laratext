<?php

if (!function_exists("sms")) {
    function sms($phone, string $message)
    {
        return SMS::to($phone)->message($message)->send();
    }
}
