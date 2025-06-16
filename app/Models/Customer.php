<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    //トレイトの使用
    // use HasFactory, SoftDeletes;

    //プロパティの定義
    // protected $table = 'customers'; 書かなくてもいいらしい
    // protected $primaryKey = 'id';  書かなくてもいいらしい
    // protected $timestamps = true;

    //属性関連の定義
    protected $fillable = [
        'customer_name',
        'customer_name_kana',
        'postal_code',
        'area_id',
        'address',
        'contact_person_name',
        'contact_person_name_kana',
        'contact_person_tel',
        'user_id',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
