<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Carbonクラスをインポート

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        $areas = [
            // ⭐ ここを 'name' に修正してください。データベースのareasテーブルのカラム名が 'name' のためです。 ⭐
            // ご提示のマイグレーションでは 'name' カラムでした: $table->string('name', 100)->comment('都道府県名');
            ['name' => '北海道', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '青森県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '岩手県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '宮城県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '秋田県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '山形県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '福島県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '茨城県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '栃木県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '群馬県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '埼玉県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '千葉県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '東京都', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '神奈川県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '新潟県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '富山県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '石川県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '福井県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '山梨県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '長野県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '岐阜県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '静岡県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '愛知県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '三重県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '滋賀県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '京都府', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '大阪府', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '兵庫県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '奈良県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '和歌山県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '鳥取県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '島根県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '岡山県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '広島県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '山口県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '徳島県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '香川県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '愛媛県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '高知県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '福岡県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '佐賀県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '長崎県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '熊本県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '大分県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '宮崎県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '鹿児島県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '沖縄県', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('areas')->insert($areas);

        // 外国キー制約チェックを再度有効化
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
