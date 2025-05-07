<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Watches'],
            ['name' => 'Shoes'],
            ['name' => 'Clothing'],
            ['name' => 'Accessories']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 