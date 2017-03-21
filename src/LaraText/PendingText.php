<?php

namespace SanthoshKorukonda\LaraText;

class PendingText
{
    /**
     * The texter instance.
     *
     * @var array
     */
    protected $texter;

    /**
     * The "to" recipients of the message.
     *
     * @var array
     */
    protected $to = [];

    /**
     * Create a new textable texter instance.
     *
     * @param  Texter  $texter
     * @return void
     */
    public function __construct(Texter $texter)
    {
        $this->texter = $texter;
    }

    /**
     * Set the recipients of the message.
     *
     * @param  mixed  $users
     * @return $this
     */
    public function to($users, string $property)
    {
        $this->to = $users;

        $this->property = $property;

        return $this;
    }

    /**
     * Send a new textable message instance.
     *
     * @param  Textable  $textable
     * @return mixed
     */
    public function send(Textable $textable)
    {
        return $this->texter->send($this->fill($textable));
    }

    /**
     * Populate the textable with the addresses.
     *
     * @param  Textable  $textable
     * @return Textable
     */
    protected function fill(Textable $textable)
    {
        return $textable->to($this->to, $this->property);
    }
}

