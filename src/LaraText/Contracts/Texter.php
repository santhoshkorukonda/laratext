<?php

namespace LaraText\Contracts;

interface Texter
{
    /**
     * Get an option value of the given key.
     *
     * @param  string  $key
     * @return object
     */
    public function get($key = null);

    /**
     * Set an option
     *
     * @param  mixed  $option
     * @return void
     */
    public function set($option);

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
    public function send();
}
