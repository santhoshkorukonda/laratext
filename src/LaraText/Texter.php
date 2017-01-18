<?php

namespace LaraText;

use stdClass;
use LaraText\Exceptions\LaraTextException;
use LaraText\Exceptions\LaraTextReferenceException;
use LaraText\Contracts\Texter as TexterContract;

class Texter implements TexterContract
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
    public function get($key = null)
    {
        if ($key === null) {
            return $this->getAll();
        } else {
            if (is_string($key)) {
                if (property_exists($this, $key)) {
                    return $this->$key;
                } else {
                    throw new LaraTextReferenceException("Reference Error: Trying to obtain value of an unknown option \"$key\".", 1);
                }
            } else {
                $type = gettype($key);
                throw new LaraTextException("Incorrect Type: Argument 1 passed to Text::get() must be of the type string, but $type given.", 1);
            }
        }
    }

    protected function getAll()
    {
        return (object) [
            "message" => $this->message
        ];
    }

    /**
     * Get an option value of the given key.
     *
     * @param  string  $key
     * @return object
     */
    public function set($option, $value = null)
    {
        if ($value === null) {
            if ($option instanceof stdClass) {
                $this->setAll($option);
                return $this;
            } else if (is_array($option)) {
                $this->setAll($option);
                return $this;
            } else {
                $type = gettype($option);
                throw new LaraTextException("Incorrect Type: Argument 1 passed to Text::set() must be of the type stdClass object or an array, but $type given.", 1);
            }
        } else {
            if (is_string($option)) {
                if (is_string($value)) {
                    if (property_exists($this, $option)) {
                        $this->$option = $value;
                        return $this;
                    } else {
                        throw new LaraTextReferenceException("Reference Error: Trying to set value to an unknown option \"$key\".", 1);
                    }
                } else {
                    $type = gettype($value);
                    throw new LaraTextException("Incorrect Type: Argument 2 passed to Text::set() must be of the type string, but $type given.", 1);
                }
            } else {
                $type = gettype($option);
                throw new LaraTextException("Expecting a string as option, but $type given.", 1);
            }
        }
    }

    /**
     * Get an option value of the given key.
     *
     * @param  string  $key
     * @return object
     */
    protected function setAll($options)
    {
        foreach ($options as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            } else {
                throw new LaraTextReferenceException("Reference Error: Trying to set unknown option \"$key\" on LaraText.", 1);
            }
        }
    }

    /**
     * Get an option value of the given key.
     *
     * @param  string  $key
     * @return object
     */
    public function to()
    {
        
    }

    /**
     * Get an option value of the given key.
     *
     * @param  string  $key
     * @return object
     */
    public function send()
    {
        
    }
}
