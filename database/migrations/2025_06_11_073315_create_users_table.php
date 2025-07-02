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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('ユーザ名');
            $table->string('name_kana', 100)->comment('ユーザ名(かな)');
            $table->string('password', 255)->default('password')->comment('パスワード');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->string('phone')->nullable()->comment('電話番号');
            $table->string('is_admin')->default('sales')->comment('権限 (営業担当者か管理者)');    // デフォルトはsalesにする
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
