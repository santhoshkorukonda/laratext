<?php

if (!function_exists("text")) {
    function text($mobiles, string $message)
    {
        return Text::to($mobiles)->message($message)->send();
    }
}
