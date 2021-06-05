<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiValuetopupCarrierPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_valuetopup_carrier_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('details_id');
            $table->string('regionAlias', 256);
            $table->integer('categoryId');
            $table->string('categoryName', 256);
            $table->string('currencyCode', 256);
            $table->decimal('amount', 10);
            $table->string('localCurrencyCode', 256);
            $table->decimal('localCurrencyAmount', 10, 0);
            $table->string('talkTime', 256);
            $table->string('validity', 256);
            $table->string('description', 512);
            $table->integer('created_at')->default(CURRENT_TIMESTAMP);
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
        Schema::dropIfExists('api_valuetopup_carrier_plans');
    }
}
