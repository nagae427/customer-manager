<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // 依存関係の順序でシーダーを呼び出す
        $this->call(UserSeeder::class);
        $this->call(AreaSeeder::class);    
        $this->call(CustomerSeeder::class); 
    }
}
