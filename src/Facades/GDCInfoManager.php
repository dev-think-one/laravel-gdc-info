<?php

namespace GDCInfo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Google\AdsApi\AdManager\v202208\OrderService createOrderService()
 * @method static \Google\AdsApi\AdManager\v202208\LineItemService createLineItemService()
 * @method static \Google\AdsApi\AdManager\v202208\CreativeService createCreativeService()
 * @method static \Google\AdsApi\AdManager\v202208\CreativeSetService createCreativeSetService()
 * @method static \Google\AdsApi\AdManager\v202208\LineItemCreativeAssociationService createLineItemCreativeAssociationService()
 */
class GDCInfoManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return  'gdc-info-manager';
    }
}
