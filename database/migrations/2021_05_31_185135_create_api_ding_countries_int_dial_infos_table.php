<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiDingCountriesIntDialInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_ding_countries_int_dial_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('CountryIso', 64);
            $table->text('Prefix')->nullable();
            $table->integer('MinimumLength')->default(0);
            $table->integer('MaximumLength')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_ding_countries_int_dial_infos');
    }
}
