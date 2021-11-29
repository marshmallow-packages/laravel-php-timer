<?php

namespace Marshmallow\PhpTimer\Facades;

class PhpTimer extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return \Marshmallow\PhpTimer\PhpTimer::class;
    }
}
