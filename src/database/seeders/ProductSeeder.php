<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = \App\Models\Category::create([
            'name' => 'Món Chính',
            'slug' => 'mon-chinh',
            'is_active' => true,
        ]);

        \App\Models\Product::create([
            'category_id' => $category->id,
            'name' => 'Cơm Gà',
            'slug' => 'com-ga',
            'price' => 50000,
            'description' => 'Cơm gà xối mỡ',
            'is_active' => true,
        ]);

        \App\Models\Product::create([
            'category_id' => $category->id,
            'name' => 'Phở Bò',
            'slug' => 'pho-bo',
            'price' => 60000,
            'description' => 'Phở bò tái nạm',
            'is_active' => true,
        ]);
    }
}
