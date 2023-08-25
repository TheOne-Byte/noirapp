<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    public function run()
    {
        // Insert sample items
        DB::table('items')->insert([
            'name' => 'Item 1',
            'description' => 'Description for Item 1',
            'price' => 10.99,
            // Add other columns as needed
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add more items as needed
    }
}
