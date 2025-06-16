<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 例: 既存のarea_idとuser_idを取得する（本番環境ではこうすると良い）
        $areaIds = DB::table('areas')->pluck('id')->toArray();  //pluckの引数で指定されたカラム(id)をtoArrayでphpの配列にして返す
        $userIds = DB::table('users')->pluck('id')->toArray();

        // もしareasテーブルやusersテーブルにデータがない場合のエラー回避
        if (empty($areaIds)) {
            echo "areasテーブルにデータがないのでAreaSeederを先に作って\n";
            return;
        }
        if (empty($userIds)) {
            echo "usersテーブルにデータがないのでUserSeederを先に作って\n";
            return;
        }

        $customers = [
            [
                'customer_name'            => '株式会社あるふぁ', // 漢字とひらがな
                'customer_name_kana'       => 'かぶしきがいしゃあるふぁ', // ひらがな
                'postal_code'              => '100-0001',
                'area_id'                  => $areaIds[array_rand($areaIds)],
                'address'                  => '東京都千代田区千代田1-1-1',
                'contact_person_name'      => '山田太郎',
                'contact_person_name_kana' => 'やまだたろう', // ひらがな
                'contact_person_tel'       => '03-1111-2222',
                'user_id'                  => $userIds[array_rand($userIds)],
                'created_at'               => now(),
                'updated_at'               => now(),
            ],
            [
                'customer_name'            => '有限会社べーた', // 漢字とひらがな
                'customer_name_kana'       => 'ゆうげんがいしゃべーた', // ひらがな
                'postal_code'              => '530-0001',
                'area_id'                  => $areaIds[array_rand($areaIds)],
                'address'                  => '大阪府大阪市北区梅田2-2-2',
                'contact_person_name'      => '田中花子',
                'contact_person_name_kana' => 'たなかはなこ', // ひらがな
                'contact_person_tel'       => '06-3333-4444',
                'user_id'                  => $userIds[array_rand($userIds)],
                'created_at'               => now(),
                'updated_at'               => now(),
            ],
            [
                'customer_name'            => '合同会社がんま', // 漢字とひらがな
                'customer_name_kana'       => 'ごうどうがいしゃがんま', // ひらがな
                'postal_code'              => '460-0001',
                'area_id'                  => $areaIds[array_rand($areaIds)],
                'address'                  => '愛知県名古屋市中区錦3-3-3',
                'contact_person_name'      => '佐藤健',
                'contact_person_name_kana' => 'さとうけん', // ひらがな
                'contact_person_tel'       => '052-555-6666',
                'user_id'                  => $userIds[array_rand($userIds)],
                'created_at'               => now(),
                'updated_at'               => now(),
            ],
            [
                'customer_name'            => '株式会社でるた', // 漢字とひらがな
                'customer_name_kana'       => 'かぶしきがいしゃでるた', // ひらがな
                'postal_code'              => '810-0001',
                'area_id'                  => $areaIds[array_rand($areaIds)],
                'address'                  => '福岡県福岡市中央区天神4-4-4',
                'contact_person_name'      => '鈴木美咲',
                'contact_person_name_kana' => 'すずきみさき', // ひらがな
                'contact_person_tel'       => '092-777-8888',
                'user_id'                  => $userIds[array_rand($userIds)],
                'created_at'               => now(),
                'updated_at'               => now(),
            ],
            [
                'customer_name'            => '有限会社いぷしろん', // 漢字とひらがな
                'customer_name_kana'       => 'ゆうげんがいしゃいぷしろん', // ひらがな
                'postal_code'              => '060-0001',
                'area_id'                  => $areaIds[array_rand($areaIds)],
                'address'                  => '北海道札幌市中央区北1条西5-5-5',
                'contact_person_name'      => '高橋翼',
                'contact_person_name_kana' => 'たかはしつばさ', // ひらがな
                'contact_person_tel'       => '011-999-0000',
                'user_id'                  => $userIds[array_rand($userIds)],
                'created_at'               => now(),
                'updated_at'               => now(),
            ],
        ];

        // データを挿入
        DB::table('customers')->insert($customers);  //データベースに挿入
    }
}
