<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Role;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $role1 = Role::query()->create([
            'name' => 'user',
        ]);

        $role2 = Role::query()->create([
            'name' => 'admin',
        ]);

        $role3 = Role::query()->create([
            'name' => 'author',
        ]);

        $tag1 = Tag::query()->create([
            'name' => 'ショーシャルビジネス',
        ]);

        $tag2 = Tag::query()->create([
            'name' => 'イベント',
        ]);

        $tag3 = Tag::query()->create([
            'name' => '初心者歓迎',
        ]);

        $user = $role2->users()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'status' => 1,
        ]);

        $category = Category::create([
            'name' => '未分類',
            'slug' => 'free-theme',
            'user_id' => $user->id,
        ]);

        $post = $user->posts()->create([
            'title' => 'This is title',
            'slug' => 'This_is_slug',
            'excerpt' => 'This is excerpt',
            'body' => 'This is content',
            'category_id' => 1,
        ]);

        $post->comments()->create([
            'the_comment' => 'test comment 1',
            'user_id' => $user->id,
        ]);

        $post->comments()->create([
            'the_comment' => 'test comment 2',
            'user_id' => $user->id,
        ]);

        $post->image()->create([
            'name' => 'post file',
            'extension' => 'jpg',
            'path' => 'images/' . rand(1, 9) . '.jpg',
        ]);

        $user->image()->create([
            'name' => 'user file',
            'extension' => 'jpg',
            'path' => 'images/' . rand(1, 9) . '.jpg',
        ]);

        $post->tags()->attach([
            $tag1->id, $tag2->id, $tag3->id
        ]);
    }
}
