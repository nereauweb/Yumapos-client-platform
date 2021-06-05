<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiReloadlyOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_reloadly_operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transactionId')->nullable();
            $table->text('operatorTransactionId')->nullable();
            $table->text('customIdentifier')->nullable();
            $table->text('recipientPhone')->nullable();
            $table->text('recipientEmail')->nullable();
            $table->text('senderPhone')->nullable();
            $table->string('countryCode', 5)->nullable();
            $table->unsignedBigInteger('operatorId')->nullable();
            $table->text('operatorName')->nullable();
            $table->decimal('discount', 10, 3)->nullable();
            $table->string('discountCurrencyCode', 5)->nullable();
            $table->decimal('requestedAmount', 10, 3)->nullable();
            $table->string('requestedAmountCurrencyCode', 5)->nullable();
            $table->decimal('deliveredAmount', 10, 3)->nullable();
            $table->string('deliveredAmountCurrencyCode', 5)->nullable();
            $table->timestamp('transactionDate')->nullable();
            $table->decimal('balance_oldBalance', 10, 3)->nullable();
            $table->decimal('balance_newBalance', 10, 3)->nullable();
            $table->string('balance_currencyCode', 5)->nullable();
            $table->text('balance_currencyName')->nullable();
            $table->timestamp('balance_updatedAt')->nullable();
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
        Schema::dropIfExists('api_reloadly_operations');
    }
}
