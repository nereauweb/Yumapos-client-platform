<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('menuroles');
            $table->rememberToken();
            $table->decimal('plafond', 10, 3)->default(0.000);
            $table->decimal('credit', 10)->nullable()->default(0.00);
            $table->decimal('debt_limit', 10, 3)->nullable()->default(0.000);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->decimal('parent_percent', 10)->nullable()->default(0.00);
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('agent_group_id')->nullable();
            $table->tinyInteger('state')->nullable()->default(1);
            $table->string('api_token', 124)->nullable();
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
        Schema::dropIfExists('users');
    }
}
