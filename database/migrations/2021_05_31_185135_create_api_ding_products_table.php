<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiDingProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_ding_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ProviderCode', 64);
            $table->string('SkuCode', 64);
            $table->text('LocalizationKey')->nullable();
            $table->decimal('CommissionRate', 10)->default(0.00);
            $table->text('ProcessingMode')->nullable();
            $table->text('RedemptionMechanism')->nullable();
            $table->text('ValidityPeriodIso')->nullable();
            $table->text('UatNumber')->nullable();
            $table->text('AdditionalInformation')->nullable();
            $table->text('DefaultDisplayText')->nullable();
            $table->text('RegionCode')->nullable();
            $table->text('LookupBillsRequired')->nullable();
            $table->text('DisplayText')->nullable();
            $table->text('DescriptionMarkdown')->nullable();
            $table->text('ReadMoreMarkdown')->nullable();
            $table->text('description_localization_key')->nullable();
            $table->text('description_language_code')->nullable();
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
        Schema::dropIfExists('api_ding_products');
    }
}
