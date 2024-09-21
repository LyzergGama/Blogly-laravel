<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run()
    {
        Post::create([
            'title' => 'First Post',
            'content' => 'This is the content of the first post.',
            'category_id' => 1, // Adjust based on your categories
        ]);
        // Add more posts as needed
    }
}
