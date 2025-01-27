<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Comment::class;

    public function definition()
    {
        $this->faker = \Faker\Factory::create('ja_JP');

        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id, // ランダムな user_id
            'item_id' => \App\Models\Item::inRandomOrder()->first()->id, // ランダムな item_id
            'comment' => $this->faker->randomElement(['購入可能ですか？', '使用方法を教えてください。', 'どこで購入されましたか？']), // ダミーコメント
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
