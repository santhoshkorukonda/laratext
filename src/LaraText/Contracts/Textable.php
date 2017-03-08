<?php

namespace SanthoshKorukonda\LaraText\Contracts;

use Illuminate\Contracts\Queue\Factory as Queue;

interface Textable
{
    /**
     * Send the message using the given texter.
     *
     * @param  Texter  $texter
     * @return void
     */
    public function send(Texter $texter);

    /**
     * Queue the given message.
     *
     * @param  Queue  $queue
     * @return mixed
     */
    public function queue(Queue $queue);

    /**
     * Deliver the queued message after the given delay.
     *
     * @param  \DateTime|int  $delay
     * @param  Queue  $queue
     * @return mixed
     */
    public function later($delay, Queue $queue);
}
