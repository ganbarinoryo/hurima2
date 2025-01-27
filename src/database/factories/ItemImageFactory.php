<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker = \Faker\Factory::create('ja_JP');

        return [
            'item_id' => \App\Models\Item::inRandomOrder()->first()->id, // ランダムな item_id
            'image_url' => $this->faker->imageUrl(640, 480, 'products', true, '商品画像'), // ダミー画像URL
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
