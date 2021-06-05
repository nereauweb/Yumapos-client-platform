<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('company_name')->nullable();
            $table->text('legal_seat')->nullable();
            $table->text('legal_seat_address')->nullable();
            $table->text('legal_seat_zip')->nullable();
            $table->text('legal_seat_city')->nullable();
            $table->text('legal_seat_region')->nullable();
            $table->text('legal_seat_country')->nullable();
            $table->text('operative_seat')->nullable();
            $table->text('operative_seat_address')->nullable();
            $table->text('operative_seat_zip')->nullable();
            $table->text('operative_seat_city')->nullable();
            $table->text('operative_seat_region')->nullable();
            $table->text('operative_seat_country')->nullable();
            $table->text('vat')->nullable();
            $table->text('tax_unique_code')->nullable();
            $table->text('pec')->nullable();
            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->text('website')->nullable();
            $table->text('support_email')->nullable();
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
        Schema::dropIfExists('providers');
    }
}
