<?php

namespace GDCInfo\Tests;

use GDCInfo\Models\GDCInfo;

class GDCInfoModelTest extends TestCase
{

    /** @test */
    public function find_or_fetch_return_null()
    {
        $gdcInfo = GDCInfo::findOrFetch(1);

        $this->assertNull($gdcInfo);
    }

    /** @test */
    public function parse_correct_info()
    {
        $gdcInfo = GDCInfo::findOrFetch(60702);

        $this->assertEquals(60702, $gdcInfo->getKey());
        $this->assertEquals('Sindhu', $gdcInfo->first_name);
        $this->assertEquals('Amin', $gdcInfo->last_name);
        $this->assertEquals('Registered', $gdcInfo->status);
        $this->assertEquals('Dentist', $gdcInfo->registrant_type);
        $this->assertEquals('BDS University of Sheffield 1985', $gdcInfo->qualifications);
        $this->assertEquals('1985-12-31', $gdcInfo->first_registered_on->format('Y-m-d'));
        $this->assertEquals('1985-12-31', $gdcInfo->current_period_from->format('Y-m-d'));
        $this->assertNotNull($gdcInfo->current_period_until);
    }
}
