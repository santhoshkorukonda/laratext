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
    public function getOption(string $key);

    /**
     * Set an option
     *
     * @param  mixed  $option
     * @return void
     */
    public function setOption($option);

    /**
     * Get all options
     *
     * @return object
     */
    public function getOptions();

    /**
     * Set given all options
     *
     * @param  mixed  $options
     * @return void
     */
    public function setOptions($options);

    /**
     * Set recipients
     *
     * @param  mixed  $to
     * @return void
     */
    public function to();

    /**
     * Text the message to given recipients
     *
     * @return object
     */
    public function send();
}
