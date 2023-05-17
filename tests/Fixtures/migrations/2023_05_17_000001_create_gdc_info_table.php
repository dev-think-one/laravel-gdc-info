<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( config('gdc-info.tables.gdc_info'), function ( Blueprint $table ) {
            \GDCInfo\MigrationHelper::defaultColumns($table);
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('gdc-info.tables.gdc_info'));
    }
};
