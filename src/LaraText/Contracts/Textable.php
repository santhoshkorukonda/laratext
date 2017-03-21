<?php

namespace SanthoshKorukonda\LaraText\Contracts;

interface Textable
{
    /**
     * Send the message using the given texter.
     *
     * @param  Texter  $texter
     * @return void
     */
    public function send(Texter $texter);
}
