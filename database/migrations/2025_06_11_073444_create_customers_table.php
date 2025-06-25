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
            $table->id();

            $table->string('name', 50)->comment('顧客名');
            $table->string('name_kana', 100)->comment('顧客名(かな)');
            $table->string('postal_code', 8)->nullable()->comment('郵便番号');
            $table->unsignedBigInteger('area_id')->nullable()->comment('都道府県ID');
            $table->string('address')->nullable()->comment('住所');
            $table->string('contact_person_name', 30)->comment('顧客担当者名');
            $table->string('contact_person_name_kana', 50)->comment('顧客担当者名(かな)');
            $table->string('contact_person_tel', 20)->comment('顧客担当者電話番号');
            $table->unsignedBigInteger('user_id');

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
