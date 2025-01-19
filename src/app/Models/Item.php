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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // user_id を外部キーとして設定
    }


    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id');
    }

    public function favoriteCount()
    {
        return $this->favoritedBy()->count();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'item_id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class); // Purchaseモデルとリレーション
    }

    

}
