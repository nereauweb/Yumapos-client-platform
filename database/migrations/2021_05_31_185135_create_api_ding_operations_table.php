<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiDingOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_ding_operations', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->text('TransferRef')->nullable();
            $table->text('DistributorRef')->nullable();
            $table->text('SkuCode')->nullable();
            $table->decimal('CustomerFee', 10, 3)->nullable();
            $table->decimal('DistributorFee', 10, 3)->nullable();
            $table->decimal('ReceiveValue', 10, 3)->nullable();
            $table->text('ReceiveCurrencyIso')->nullable();
            $table->decimal('ReceiveValueExcludingTax', 10, 3)->nullable();
            $table->decimal('TaxRate', 10, 3)->nullable();
            $table->decimal('TaxName', 10, 3)->nullable();
            $table->text('TaxCalculation')->nullable();
            $table->decimal('SendValue', 10, 3)->nullable();
            $table->text('SendCurrencyIso')->nullable();
            $table->decimal('CommissionApplied', 10, 3)->nullable();
            $table->text('StartedUtc')->nullable();
            $table->text('CompletedUtc')->nullable();
            $table->text('ProcessingState')->nullable();
            $table->text('ReceiptText')->nullable();
            $table->text('ReceiptParams')->nullable();
            $table->text('AccountNumber')->nullable();
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
        Schema::dropIfExists('api_ding_operations');
    }
}
