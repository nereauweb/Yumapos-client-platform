<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiValuetopupProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_valuetopup_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('skuId');
            $table->string('productName', 256);
            $table->text('description')->nullable();
            $table->integer('faceValue');
            $table->integer('minAmount');
            $table->integer('maxAmount');
            $table->integer('discount');
            $table->string('category', 256);
            $table->integer('isSalesTaxCharged');
            $table->integer('exchangeRate');
            $table->string('currencyCode', 256);
            $table->string('countryCode', 256);
            $table->integer('localPhoneNumberLength');
            $table->integer('allowDecimal');
            $table->integer('fee');
            $table->string('operatorName', 256);
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
        Schema::dropIfExists('api_valuetopup_products');
    }
}
