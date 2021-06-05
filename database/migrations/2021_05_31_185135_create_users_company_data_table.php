<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersCompanyDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_company_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
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
            $table->decimal('vat_percent', 5)->nullable()->default(22.00);
            $table->decimal('witholding_tax_percent', 5)->nullable()->default(0.00);
            $table->text('pec')->nullable();
            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->text('mobile')->nullable();
            $table->text('referent_name')->nullable();
            $table->text('referent_surname')->nullable();
            $table->text('referent_mobile')->nullable();
            $table->text('shop_sign')->nullable();
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
        Schema::dropIfExists('users_company_data');
    }
}
