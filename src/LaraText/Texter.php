<?php

namespace SanthoshKorukonda\LaraText;

# Contracts
use SanthoshKorukonda\LaraText\Contracts\Texter as TexterContract;
use SanthoshKorukonda\LaraText\Contracts\Textable as TextableContract;
use SanthoshKorukonda\LaraText\Contracts\Transport as TransportContract;

class Texter implements TexterContract
{
    /**
     * Transport driver to text the message.
     *
     * @var Transport
     */
    protected $transport;

    /**
     * Get an option value of the given key.
     *
     * @param  TransportContract  $transport
     * @return void
     */
    public function __construct(TransportContract $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Begin the process of texting a textable class instance.
     *
     * @param  mixed  $users
     * @return \SanthoshKorukonda\LaraText\PendingText
     */
    public function to($users, string $property = "mobile")
    {
        return (new PendingText($this))->to($users, $property);
    }

    public function send(TextableContract $textable)
    {
        $message = $textable->send($this);

        return $this->transport->send($message);
    }

    public function failures()
    {
        # code...
    }
}
