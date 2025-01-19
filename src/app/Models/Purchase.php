<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class); // 購入者
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id'); // item_id を外部キーとして設定
    }

}
