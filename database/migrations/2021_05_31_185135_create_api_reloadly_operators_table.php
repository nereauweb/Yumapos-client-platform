<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiReloadlyOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_reloadly_operators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('operatorId');
            $table->string('name', 256);
            $table->tinyInteger('bundle')->nullable()->default(0);
            $table->tinyInteger('data')->nullable()->default(0);
            $table->tinyInteger('pin')->nullable()->default(0);
            $table->tinyInteger('supportsLocalAmounts')->nullable()->default(0);
            $table->string('denominationType', 256)->nullable();
            $table->string('senderCurrencyCode', 256)->nullable();
            $table->string('senderCurrencySymbol', 256)->nullable();
            $table->string('destinationCurrencyCode', 256)->nullable();
            $table->string('destinationCurrencySymbol', 256)->nullable();
            $table->decimal('commission', 10, 3)->nullable()->default(0.000);
            $table->decimal('internationalDiscount', 10, 3)->nullable()->default(0.000);
            $table->decimal('localDiscount', 10, 3)->nullable()->default(0.000);
            $table->decimal('mostPopularAmount', 10, 3)->nullable()->default(0.000);
            $table->decimal('minAmount', 10, 3)->nullable()->default(0.000);
            $table->decimal('maxAmount', 10, 3)->nullable()->default(0.000);
            $table->decimal('localMinAmount', 10, 3)->nullable()->default(0.000);
            $table->decimal('localMaxAmount', 10, 3)->nullable()->default(0.000);
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
        Schema::dropIfExists('api_reloadly_operators');
    }
}
