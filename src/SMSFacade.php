<?php

namespace SantoshKorukonda\SMS;

use Illuminate\Support\Facades\Facade;

class SMSFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'santoshkorukonda.sms';
    }
}
