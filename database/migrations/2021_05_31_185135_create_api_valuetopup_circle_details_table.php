<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiValuetopupCircleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_valuetopup_circle_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('operatorAlias', 256);
            $table->string('operatorName', 256);
            $table->string('regionAlias', 256);
            $table->string('regionName', 256);
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
        Schema::dropIfExists('api_valuetopup_circle_details');
    }
}
