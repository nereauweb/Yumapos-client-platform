<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_operators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 512);
            $table->bigInteger('country_id');
            $table->enum('master', ['ding', 'reloadly']);
            $table->string('ding_ProviderCode', 256)->nullable();
            $table->string('reloadly_operatorId', 256)->nullable();
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
        Schema::dropIfExists('service_operators');
    }
}
