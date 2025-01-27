<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchase;

class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Purchase::class;
    
    public function definition()
    {
        $this->faker = \Faker\Factory::create('ja_JP');

        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id, // ランダムな user_id
            'item_id' => \App\Models\Item::inRandomOrder()->first()->id, // ランダムな item_id
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
