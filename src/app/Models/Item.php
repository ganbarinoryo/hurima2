<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Item extends Model
{
    use HasFactory;

    protected $fillable = [
            'item_name',
            'description',
            'category',
            'condition',
            'price',
            'user_id',
            'status',
        ];

        // デフォルト値の設定
        protected static function boot()
        {
            parent::boot();

            static::creating(function ($item) {
                if (empty($item->status)) {
                    $item->status = '販売中'; // デフォルト値を設定
                }
            });
        }

    // item_imagesテーブルとのリレーション
    public function images()
    {
        return $this->hasMany(ItemImage::class, 'item_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }
}
