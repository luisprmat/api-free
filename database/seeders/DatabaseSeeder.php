<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::deleteDirectory('posts');
        Storage::makeDirectory('posts');

        $this->call([
            RoleSeeder::class,
            UserSeeder::class
        ]);

        Category::factory()->count(4)->create();
        Tag::factory()->count(8)->create();

        $this->call(PostSeeder::class);
    }
}
