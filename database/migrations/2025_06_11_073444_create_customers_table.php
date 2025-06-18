<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('customer_name', 50);
            $table->string('customer_name_kana', 100);
            $table->string('postal_code', 8)->nullable();
            $table->unsignedBigInteger('area_id')->nullable();  //外部キー
            $table->string('address')->nullable();
            $table->string('contact_person_name', 30);
            $table->string('contact_person_name_kana', 50);
            $table->string('contact_person_tel', 20);
            $table->unsignedBigInteger('user_id');  //外部キー

            $table->timestamps();

            // 外部キー制約
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
