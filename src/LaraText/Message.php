<?php

namespace SanthoshKorukonda\LaraText;

# Exceptions
use SanthoshKorukonda\LaraText\Exceptions\LaraTextException;

# Contracts
use SanthoshKorukonda\LaraText\Contracts\Message as MessageContract;
use SanthoshKorukonda\LaraText\Contracts\Textable as TextableContract;

class Message implements MessageContract
{
    /**
     * The Swift Message instance.
     *
     * @var string|array
     */
    protected $to;

    protected $from;

    protected $route;

    protected $options;

    protected $message;

    protected $textable;

    /**
     * Create a new message instance.
     *
     * @param  \Swift_Message  $swift
     * @return void
     */
    public function __construct(TextableContract $textable)
    {
        $this->textable = $textable;

        $this->buildMessage();
    }

    protected function buildMessage()
    {
        $this->buildFrom();

        $this->buildTo();

        $this->buildRoute();

        $this->buildOptions();

        $this->buildContent();
    }

    protected function buildFrom()
    {
        if (empty($this->textable->from)) {
            $globalFrom = config("text.from");
            if (empty($globalFrom)) {
                throw new LaraTextException('No "[sender ID]" is defined on the message.', 1);
            } else {
                $this->from = $globalFrom;
            }
        } else {
            $this->from = $this->textable->from;
        }
    }

    protected function buildTo()
    {
        $autoPrefix = config("text.country.autoPrefix");

        if ($autoPrefix) {
            $this->to = $this->autoPrefixMobiles();
        } else {
            $this->to = implode(",", $this->textable->to);
        }
    }

    protected function autoPrefixMobiles()
    {
        $prefix = config("text.country.default");

        $addresses = collect($this->textable->to)->transform(function ($address) use ($prefix) {

            return $prefix . $address;
        });
        return implode(",", $addresses->all());
    }

    protected function buildContent()
    {
        $this->message = $this->textable->message;
    }

    protected function buildRoute()
    {
        if (empty($this->textable->route)) {

            $globalRoute = config("text.route");

            if (empty($globalRoute)) {

                throw new LaraTextException('No "[Route]" is defined for the message.', 1);
            } else {
                $this->route = $globalRoute;
            }
        } else {
            $this->route = $this->textable->route;
        }
    }

    protected function buildOptions()
    {
        $this->options = $this->textable->options;
    }

    /**
     * Add a "from" address to the message.
     *
     * @param  string|array  $address
     * @param  string|null  $name
     * @return $this
     */
    public function from()
    {
        return $this->from;
    }

    /**
     * Set the "sender" of the message.
     *
     * @param  string|array  $address
     * @param  string|null  $name
     * @return $this
     */
    public function to()
    {
        return $this->to;
    }

    /**
     * Set the "return path" of the message.
     *
     * @param  string  $address
     * @return $this
     */
    public function content()
    {
        return $this->message;
    }

    public function route()
    {
        return $this->route;
    }

    public function options()
    {
        return $this->options;
    }
}
