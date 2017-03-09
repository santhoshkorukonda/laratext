<?php

namespace SanthoshKorukonda\LaraText\Bootstrap;

use Illuminate\Support\Facades\Facade;

class Text extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'texter';
    }
}
