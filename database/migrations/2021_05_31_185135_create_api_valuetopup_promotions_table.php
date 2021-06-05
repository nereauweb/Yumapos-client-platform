<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiValuetopupPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_valuetopup_promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('promotionName', 256);
            $table->timestamp('startDate')->useCurrent();
            $table->timestamp('endDate')->default('0000-00-00 00:00:00');
            $table->string('description', 256);
            $table->string('restriction', 256);
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
        Schema::dropIfExists('api_valuetopup_promotions');
    }
}
