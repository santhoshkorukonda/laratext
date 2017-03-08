<?php

namespace LaraText\Contracts;

interface Texter
{
    /**
     * Send a new message using a text.
     *
     * @param  string|array  $text
     * @return void
     */
    public function send($text);

    /**
     * Get the array of failed recipients.
     *
     * @return array
     */
    public function failures();
}
