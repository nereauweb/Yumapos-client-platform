<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiDingOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_ding_operators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ProviderCode', 64);
            $table->string('CountryIso', 64)->nullable();
            $table->text('Name')->nullable();
            $table->text('ShortName')->nullable();
            $table->text('ValidationRegex')->nullable();
            $table->text('CustomerCareNumber')->nullable();
            $table->text('LogoUrl')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_ding_operators');
    }
}
