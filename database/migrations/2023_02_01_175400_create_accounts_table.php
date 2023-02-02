<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->string('mail')->primary();
            $table->string('password');
            $table->string('qr_code');
            $table->string('qr_link')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->boolean('has_kids')->default(false);
            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
