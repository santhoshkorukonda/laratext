<?php

namespace LaraText;

use LaraText\Contracts\Texter as TexterContract;

class Texter extends TexterContract
{
    /**
     * Message to send.
     *
     * @var  string  $message
     */
    protected $message = null;

    /**
     * List of recipient addresses.
     *
     * @var  string  $to
     */
    protected $to;

    /**
     * Get an option value of the given key.
     *
     * @param  string  $key
     * @return object
     */
    public function getOption(string $key)
    {
        
    }
}
