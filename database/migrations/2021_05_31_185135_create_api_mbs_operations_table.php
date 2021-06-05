<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiMbsOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_mbs_operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('operation_id');
            $table->string('product', 64);
            $table->unsignedBigInteger('user_id');
            $table->string('number', 64)->nullable();
            $table->decimal('amount', 10, 3)->nullable();
            $table->decimal('platform_balance_before', 10, 3)->nullable();
            $table->decimal('platform_balance_after', 10, 3)->nullable();
            $table->decimal('cost', 10, 3)->nullable();
            $table->string('response', 64)->nullable();
            $table->text('ref')->nullable();
            $table->text('pin')->nullable();
            $table->text('pin_serial')->nullable();
            $table->text('pin_expiry')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('api_mbs_operations');
    }
}
