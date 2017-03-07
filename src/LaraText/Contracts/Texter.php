<?php

namespace LaraText\Contracts;

interface Texter
{
    /**
     * Set recipients
     *
     * @param  mixed  $to
     * @return void
     */
    public function to($to);

    /**
     * Text the message to given recipients
     *
     * @return object
     */
    public function send($textable);
}
