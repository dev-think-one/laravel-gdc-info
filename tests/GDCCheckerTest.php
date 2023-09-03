<?php

namespace GDCInfo\Tests;

use GDCInfo\GDCChecker;
use GDCInfo\Models\GDCInfo;
use GDCInfo\Tests\Fixtures\Models\CustomGDCInfo;
use Illuminate\Foundation\Auth\User;

class GDCCheckerTest extends TestCase
{
    /** @test */
    public function change_model()
    {
        GDCChecker::useModel(CustomGDCInfo::class);

        $this->assertEquals(CustomGDCInfo::class, GDCChecker::modelClass());

        GDCChecker::useModel(GDCInfo::class);

        $this->assertEquals(GDCInfo::class, GDCChecker::modelClass());

        $this->assertInstanceOf(GDCInfo::class, GDCChecker::model());
    }

    /** @test */
    public function exception_if_not_correct_model()
    {
        $this->expectExceptionMessage('Class should be a subclass of GDCInfo [Illuminate\Foundation\Auth\User]');

        GDCChecker::useModel(User::class);
    }
}
