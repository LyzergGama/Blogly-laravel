<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Music',
            'Lifestyle',
            'Finance',
            'Automotive',
            'Technology',
            'Health',
            'Travel',
            'Education',
            'Food',
            'Fashion',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}