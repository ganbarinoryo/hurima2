<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_name', // 追加
        'user_icon', // 追加
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function favorites()
    {
        return $this->belongsToMany(Item::class, 'favorites', 'user_id', 'item_id');
    }

    // コメントとのリレーション
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class); // 購入履歴とのリレーション
    }

    public function purchasedItems()
    {
        return $this->hasManyThrough(
            Item::class, // 取得対象のモデル
            Purchase::class, // 経由するモデル
            'user_id', // PurchaseテーブルでUserを識別する外部キー
            'id', // ItemテーブルでItemを識別するキー
            'id', // UserテーブルでUserを識別するキー
            'item_id' // PurchaseテーブルでItemを識別する外部キー
        );
    }
}
