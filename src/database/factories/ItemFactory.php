<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
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
        'user_id' => \App\Models\User::inRandomOrder()->first()->id, // ランダムなユーザーID
        'item_name' => $this->faker->randomElement(['自転車', '包丁','ノートパソコン','スマートフォン','マグセーフ','車']),
        'condition' => $this->faker->randomElement(['新品', '中古']),
        'status' => $this->faker->randomElement(['販売中', '売却済']),
        'description' => $this->faker->randomElement(['状態の良い品物です。綺麗なうちに使っていただける方にお譲りします。', '大変綺麗な状態です。', 'まだまだ使用できます。']),
        'price' => $this->faker->randomFloat(2, 100, 10000), // 100~10000円
        'category' => $this->faker->randomElement(['日用雑貨', 'アウトドア', 'スポーツ']),
        'created_at' => now(),
        'updated_at' => now(),
        ];
    }
}
