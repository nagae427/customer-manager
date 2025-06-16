<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;   // DBファサードをインポート
use Illuminate\Support\Facades\Hash; // Hashファサードをインポート

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 既存のデータがあれば一度クリアする（オプション）
        // DB::table('users')->truncate(); 

        $users = [
            [
                'user_name'  => 'システム管理者',
                'password'   => Hash::make('password'), // ハッシュ化されたパスワード
                'authority'  => 'admin', // 管理者権限
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name'  => '田中 太郎',
                'password'   => Hash::make('password'),
                'authority'  => 'sales', // 営業担当者
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name'  => '佐藤 花子',
                'password'   => Hash::make('password'),
                'authority'  => 'sales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name'  => '鈴木 次郎', 
                'password'   => Hash::make('password'),
                'authority'  => 'sales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name'  => '山田 美咲', 
                'password'   => Hash::make('password'),
                'authority'  => 'sales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // データを挿入
        DB::table('users')->insert($users);
    }
}