<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemImage;

class ItemImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ItemImage::factory(3)->create();
    }
}
