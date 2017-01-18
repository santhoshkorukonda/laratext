<?php

namespace LaraText\Exceptions;

use Exception;

class LaraTextReferenceException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->giveCustomTrace();
    }

    protected function giveCustomTrace()
    {
        $stackTrace = $this->getTrace();

        foreach ($stackTrace as $key => $trace) {

            if ($trace["function"] == "__callStatic") {

                $this->line = $stackTrace[$key]["line"];

                $this->file = $stackTrace[$key]["file"];

                break;
            }
        }
    }
}
