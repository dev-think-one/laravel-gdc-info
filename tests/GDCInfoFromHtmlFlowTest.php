<?php

namespace GDCInfo\Tests;

use GDCInfo\Exceptions\FindGDCInfoException;
use GDCInfo\Exceptions\NotFoundGDCInfoException;
use GDCInfo\Flows\GDCInfoFromHtmlFlow;

class GDCInfoFromHtmlFlowTest extends TestCase
{
    /** @test */
    public function exception_if_not_found()
    {
        $this->expectException(NotFoundGDCInfoException::class);
        GDCInfoFromHtmlFlow::make()->get('000001');
    }

    /** @test */
    public function parse_correct_info()
    {
        $gdcInfo = GDCInfoFromHtmlFlow::make()->get('060702');

        $this->assertEquals(60702, $gdcInfo->gdc());
        $this->assertEquals('Sindhu', $gdcInfo->firstName());
        $this->assertEquals('Amin', $gdcInfo->lastName());
        $this->assertEquals('Registered', $gdcInfo->status());
        $this->assertEquals('Dentist', $gdcInfo->registrantType());
        $this->assertEquals('BDS University of Sheffield 1985', $gdcInfo->qualifications());
        $this->assertEquals('1985-12-31', $gdcInfo->firstRegisteredOn()->format('Y-m-d'));
        $this->assertEquals('1985-12-31', $gdcInfo->currentPeriodFrom()->format('Y-m-d'));
        $this->assertNotNull($gdcInfo->currentPeriodUntil());

        $this->assertEmpty($gdcInfo->additionalInfo());
    }

    /** @test */
    public function parse_correct_info_with_additional_info()
    {
        $gdcInfo = GDCInfoFromHtmlFlow::make()->get('146041');

        $this->assertEquals(146041, $gdcInfo->gdc());
        $this->assertEquals('Jane Frederica', $gdcInfo->firstName());
        $this->assertEquals('Birkett', $gdcInfo->lastName());
        $this->assertEquals('Registered', $gdcInfo->status());
        $this->assertEquals('Dental Care Professional', $gdcInfo->registrantType());
        $this->assertEquals('Verified competency in Dental Nursing', $gdcInfo->qualifications());
        $this->assertEquals('2008-05-12', $gdcInfo->firstRegisteredOn()->format('Y-m-d'));
        $this->assertEquals('2008-05-12', $gdcInfo->currentPeriodFrom()->format('Y-m-d'));
        $this->assertNotNull($gdcInfo->currentPeriodUntil());

        $this->assertNotEmpty($gdcInfo->additionalInfo());
    }

    /** @test */
    public function parse_incorrect_info()
    {
        $this->expectException(FindGDCInfoException::class);
        $this->expectExceptionMessage('Invalid gdc number [0000].');

        GDCInfoFromHtmlFlow::make()->get('0000');
    }

}
