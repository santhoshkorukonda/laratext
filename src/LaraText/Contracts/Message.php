<?php

namespace SanthoshKorukonda\LaraText\Contracts;

interface Message
{
    /**
     * Get the senderId of the message.
     *
     * @return string
     */
    public function from();

    /**
     * Get the "to" address of the message.
     *
     * @return string|array
     */
    public function to();

    /**
     * Get the content of the message.
     *
     * @return string
     */
    public function content();
}
