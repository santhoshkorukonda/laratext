<?php

namespace SanthoshKorukonda\LaraText\Contracts;

interface TextQueue
{
    /**
     * Queue a new text message for sending.
     *
     * @param  string|array  $text
     * @param  string  $queue
     * @return mixed
     */
    public function queue($text, $queue = null);

    /**
     * Queue a new text message for sending after (n) seconds.
     *
     * @param  int  $delay
     * @param  string|array  $text
     * @param  string  $queue
     * @return mixed
     */
    public function later($delay, $text, $queue = null);
}
