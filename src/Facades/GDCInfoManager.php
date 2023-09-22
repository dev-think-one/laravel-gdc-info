<?php

namespace GDCInfo\Facades;

use Illuminate\Support\Facades\Facade;

class GDCInfoManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return  'gdc-info-manager';
    }
}
