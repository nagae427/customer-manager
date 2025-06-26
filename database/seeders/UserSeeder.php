<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // DBファサードを使用
use Illuminate\Support\Facades\Hash; // パスワードのハッシュ化に使用
use Carbon\Carbon; // 日付の生成に使用

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            [
                'name' => '管理者太郎',
                'name_kana' => 'カンリシャタロウ',
                'email' => 'admin_taro@example.com', // メールアドレスを追加
                'phone' => '09011112222',       // 電話番号を追加
                'password' => Hash::make('password'),
                'is_admin' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '営業一郎',
                'name_kana' => 'エイギョウイチロウ',
                'email' => 'sales_ichiro@example.com', // メールアドレスを追加
                'phone' => '09033334444',        // 電話番号を追加
                'password' => Hash::make('password'),
                'is_admin' => 'sales',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '管理者花子',
                'name_kana' => 'カンリシャハナコ',
                'email' => 'admin_hanako@example.com', // メールアドレスを追加
                'phone' => '09055556666',        // 電話番号を追加
                'password' => Hash::make('password'),
                'is_admin' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '営業二郎',
                'name_kana' => 'エイギョウジロウ',
                'email' => 'sales_jiro@example.com',   // メールアドレスを追加
                'phone' => '09077778888',        // 電話番号を追加
                'password' => Hash::make('password'),
                'is_admin' => 'sales',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '管理者三郎',
                'name_kana' => 'カンリシャサブロウ',
                'email' => 'admin_saburo@example.com', // メールアドレスを追加
                'phone' => '09099990000',        // 電話番号を追加
                'password' => Hash::make('password'),
                'is_admin' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}