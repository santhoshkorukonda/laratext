<?php

namespace SanthoshKorukonda\LaraText;

use Illuminate\Support\Collection;
use Illuminate\Container\Container;
use SanthoshKorukonda\LaraText\Exceptions\LaraTextException;
use SanthoshKorukonda\LaraText\Exceptions\LaraTextReferenceException;
use SanthoshKorukonda\LaraText\Contracts\Textable as TextableContract;
use SanthoshKorukonda\LaraText\Contracts\Texter as TexterContract;

class Textable implements TextableContract
{
    /**
     * The person the message is from.
     *
     * @var string
     */
    public $from;

    /**
     * List of recipient addresses.
     *
     * @var array
     */
    public $to = [];

    /**
     * The content of the message.
     *
     * @var string
     */
    public $message;

    /**
     * Which route does the message should be routed
     *
     * @var  string
     */
    public $route;

    public $options = [];

    /**
     * Set the sender of the message.
     *
     * @param  string  $senderId
     * @return $this
     */
    public function from(string $senderId)
    {
        $this->senderId = $senderId;

        return $this;
    }

    /**
     * Set the recipients of the message.
     *
     * @param  object|array|string  $address
     * @param  string  $property
     * @return $this
     */
    public function to($address, string $property)
    {
        foreach ($this->addressesToArray($address, $property) as $recipient) {

            $recipient = $this->normalizeRecipient($recipient, $property);

            $this->to[] = $recipient->{$property};
        }
        return $this;
    }

    /**
     * Determine if the given recipient is set on the textable.
     *
     * @param  object|array|string  $address
     * @param  string  $property
     * @return bool
     */
    protected function hasTo($address, string $property = "mobile")
    {
        $expected = $this->normalizeRecipient(
            $this->addressesToArray($address, $property)[0], $property
        );
        $expected = $expected->{$property};

        return collect($this->to)->contains(function ($actual) use ($expected) {
            return $actual == $expected;
        });
    }

    /**
     * Convert the given recipient arguments to an array.
     *
     * @param  object|array|string  $address
     * @param  string  $property
     * @return array
     */
    protected function addressesToArray($address, string $property)
    {
        if (! is_array($address) && ! $address instanceof Collection) {

            $address = is_string($address) ? [["$property" => $address]] : [$address];
        }
        return $address;
    }

    /**
     * Convert the given recipient into an object.
     *
     * @param  mixed  $recipient
     * @return object
     */
    protected function normalizeRecipient($recipient, string $property)
    {
        if (is_array($recipient)) {

            return (object) $recipient;

        } elseif (is_string($recipient)) {

            return (object) ["$property" => $recipient];
        }
        return $recipient;
    }

    /**
     * Set the content of the message.
     *
     * @param  string  $message
     * @return $this
     */
    public function content(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the route for the message.
     *
     * @param  int  $route
     * @return $this
     */
    public function route(int $route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Set any additional options to text the message.
     *
     * @param  array  $options
     * @return $this
     */
    public function options(array $options)
    {
        $this->options = $options;

        return $this;
    }

    public function send(TexterContract $texter)
    {
        Container::getInstance()->call([$this, 'build']);

        return (new Message($this));
    }
}
