<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiDingOperatorsConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_ding_operators_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('operator_ProviderCode', 10);
            $table->unsignedBigInteger('group_id');
            $table->decimal('fx_delta_percent', 10)->nullable()->default(0.00);
            $table->decimal('discount_percent', 10)->nullable()->default(0.00);
            $table->tinyInteger('enabled')->nullable()->default(1);
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
        Schema::dropIfExists('api_ding_operators_configurations');
    }
}
