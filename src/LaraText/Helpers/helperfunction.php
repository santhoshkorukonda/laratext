<?php

if (!function_exists("text")) {
    function text($phone, string $message)
    {
        return Text::to($phone)->message($message)->send();
    }
}
