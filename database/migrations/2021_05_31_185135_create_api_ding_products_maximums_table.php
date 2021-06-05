<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiDingProductsMaximumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_ding_products_maximums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('CustomerFee', 10, 3)->default(0.000);
            $table->decimal('DistributorFee', 10, 3)->default(0.000);
            $table->decimal('ReceiveValue', 10, 3)->default(0.000);
            $table->text('ReceiveCurrencyIso')->nullable();
            $table->decimal('ReceiveValueExcludingTax', 10, 3)->default(0.000);
            $table->decimal('TaxRate', 10, 3)->default(0.000);
            $table->text('TaxName')->nullable();
            $table->text('TaxCalculation')->nullable();
            $table->decimal('SendValue', 10, 3)->default(0.000);
            $table->text('SendCurrencyIso')->nullable();
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
        Schema::dropIfExists('api_ding_products_maximums');
    }
}
