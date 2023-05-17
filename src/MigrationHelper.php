<?php

namespace GDCInfo;

use Illuminate\Database\Schema\Blueprint;

class MigrationHelper
{
    public static function defaultColumns(Blueprint $table)
    {
        $table->unsignedBigInteger('gdc');
        $table->string('first_name')->nullable()->index();
        $table->string('last_name')->nullable()->index();
        $table->string('status')->nullable()->index();
        $table->string('registrant_type')->nullable()->index();
        $table->text('qualifications')->nullable();
        $table->date('first_registered_on')->nullable();
        $table->date('current_period_from')->nullable();
        $table->date('current_period_until')->nullable();
        $table->json('data')->nullable();
        $table->dateTime('last_fetched_at');
        $table->timestamps();
    }
}
