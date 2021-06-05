<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('provider', ['reloadly', 'ding', 'mbs'])->nullable()->default('reloadly');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('api_reloadly_calls_id')->nullable();
            $table->unsignedBigInteger('api_reloadly_operations_id')->nullable();
            $table->text('reloadly_transactionId')->nullable();
            $table->text('ding_TransferRef')->nullable();
            $table->unsignedBigInteger('api_ding_call_id')->nullable();
            $table->unsignedBigInteger('api_ding_operation_id')->nullable();
            $table->unsignedBigInteger('api_mbs_operation_id')->nullable();
            $table->tinyInteger('result');
            $table->unsignedBigInteger('request_operatorId')->nullable();
            $table->string('request_ProviderCode', 64)->nullable();
            $table->string('request_Prodotto', 64)->nullable();
            $table->decimal('request_amount', 10, 3)->nullable();
            $table->tinyInteger('request_local')->nullable()->default(0);
            $table->string('request_country_iso', 5)->nullable();
            $table->text('request_recipient_phone')->nullable();
            $table->decimal('original_expected_destination_amount', 10, 3)->nullable()->default(0.000);
            $table->decimal('final_expected_destination_amount', 10, 3)->nullable()->default(0.000);
            $table->decimal('sent_amount', 10, 3)->nullable()->default(0.000);
            $table->decimal('user_amount', 10)->nullable()->default(0.00);
            $table->decimal('user_gain', 10, 3)->nullable()->default(0.000);
            $table->decimal('final_amount', 10, 3)->nullable()->default(0.000);
            $table->decimal('user_discount', 10, 3)->nullable()->default(0.000);
            $table->decimal('platform_commission', 10, 3)->default(0.000);
            $table->decimal('user_old_plafond', 10, 3)->nullable()->default(0.000);
            $table->decimal('user_new_plafond', 10, 3)->nullable()->default(0.000);
            $table->decimal('user_total_gain', 10, 3)->nullable()->default(0.000);
            $table->decimal('agent_commission', 10, 3)->nullable()->default(0.000);
            $table->decimal('platform_total_gain', 10, 3)->nullable()->default(0.000);
            $table->text('pin')->nullable();
            $table->enum('report_status', ['reported', 'confirmed', 'sent', 'rejected', 'refunded'])->nullable();
            $table->text('report_notes')->nullable();
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
        Schema::dropIfExists('service_operations');
    }
}
