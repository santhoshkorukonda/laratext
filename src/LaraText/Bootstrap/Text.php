<?php

namespace LaraText\Bootstrap;

use Illuminate\Support\Facades\Facade;

class Text extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laratext.texter';
    }
}
