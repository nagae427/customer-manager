<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'name_kana',
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
