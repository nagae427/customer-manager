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
                'user_name'      => 'システム管理者',
                'user_name_kana' => 'しすてむかんりしゃ', // ★ 追加
                'password'       => Hash::make('password'), // ハッシュ化されたパスワード
                'authority'      => 'admin', // 管理者権限
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'user_name'      => '田中 太郎',
                'user_name_kana' => 'たなか たろう', // ★ 追加
                'password'       => Hash::make('password'),
                'authority'      => 'sales', // 営業担当者
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'user_name'      => '佐藤 花子',
                'user_name_kana' => 'さとう はなこ', // ★ 追加
                'password'       => Hash::make('password'),
                'authority'      => 'sales',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'user_name'      => '鈴木 次郎',
                'user_name_kana' => 'すずき じろう', // ★ 追加
                'password'       => Hash::make('password'),
                'authority'      => 'sales',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'user_name'      => '山田 美咲',
                'user_name_kana' => 'やまだ みさき', // ★ 追加
                'password'       => Hash::make('password'),
                'authority'      => 'sales',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ];

        // データを挿入
        DB::table('users')->insert($users);
    }
}