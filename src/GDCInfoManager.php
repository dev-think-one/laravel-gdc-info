<?php

namespace GDCInfo;

use GDCInfo\Exceptions\FindGDCInfoException;
use GDCInfo\Flows\GDCInfoFromHtmlFlow;

class GDCInfoManager
{
    /**
     * @param string $gdcNumber
     * @return GDCInfo
     * @throws FindGDCInfoException
     */
    public function infoByGdcNumber(string $gdcNumber): GDCInfo
    {
        return GDCInfoFromHtmlFlow::make()->get($gdcNumber);
    }
}
