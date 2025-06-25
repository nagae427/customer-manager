<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // DBファサードを使用
use Carbon\Carbon; // 日付の生成に使用

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $firstUserId = DB::table('users')->value('id');
        $firstAreaId = DB::table('areas')->value('id');

        $customers = [
            [
                'name' => 'テスト顧客A',
                'name_kana' => 'テストコキャクエー',
                'postal_code' => '100-0001',
                'area_id' => $firstAreaId, 
                'address' => '東京都千代田区1-1-1',
                'contact_person_name' => '山田 太郎',
                'contact_person_name_kana' => 'ヤマダタロウ',
                'contact_person_tel' => '03-1234-5678',
                'user_id' => $firstUserId, 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'サンプル商事',
                'name_kana' => 'サンプルショウジ',
                'postal_code' => '530-0001',
                'area_id' => $firstAreaId, 
                'address' => '大阪府大阪市北区1-2-3',
                'contact_person_name' => '田中 花子',
                'contact_person_name_kana' => 'タナカハナコ',
                'contact_person_tel' => '06-9876-5432',
                'user_id' => $firstUserId, 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '株式会社B',
                'name_kana' => 'カブシキガイシャビー',
                'postal_code' => '810-0002',
                'area_id' => $firstAreaId,
                'address' => '福岡県福岡市中央区4-5-6',
                'contact_person_name' => '佐藤 健太',
                'contact_person_name_kana' => 'サトウケンタ',
                'contact_person_tel' => '092-111-2222',
                'user_id' => $firstUserId, 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '合同会社C',
                'name_kana' => 'ゴウドウガイシャシー',
                'postal_code' => '060-0000',
                'area_id' => $firstAreaId, 
                'address' => '北海道札幌市中央区7-8-9',
                'contact_person_name' => '鈴木 麗奈',
                'contact_person_name_kana' => 'スズキレイナ',
                'contact_person_tel' => '011-333-4444',
                'user_id' => $firstUserId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '有限会社D',
                'name_kana' => 'ユウゲンガイシャディー',
                'postal_code' => '460-0003',
                'area_id' => $firstAreaId,
                'address' => '愛知県名古屋市中区10-11-12',
                'contact_person_name' => '高橋 雄介',
                'contact_person_name_kana' => 'タカハシユウスケ',
                'contact_person_tel' => '052-555-6666',
                'user_id' => $firstUserId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // データベースにデータを挿入
        DB::table('customers')->insert($customers);
    }
}
