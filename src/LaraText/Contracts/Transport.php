<?php

namespace SanthoshKorukonda\LaraText\Contracts;

use SanthoshKorukonda\LaraText\Message;

interface Transport
{
    /**
     * Send a new message using a text.
     *
     * @param  string|array  $text
     * @return void
     */
    public function send(Message $message);
}
