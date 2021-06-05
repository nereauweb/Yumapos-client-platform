<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiMbsProductsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_mbs_products_list', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('Prodotto', 256);
            $table->string('Operatore', 256);
            $table->string('Tipo', 256);
            $table->string('SottoTipo', 256);
            $table->text('Descrizione');
            $table->decimal('PrezzoUtente', 10, 3);
            $table->text('image')->nullable();
            $table->decimal('Costo', 10, 0)->nullable();
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
        Schema::dropIfExists('api_mbs_products_list');
    }
}
