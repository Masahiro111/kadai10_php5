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

        // ロール名の初期設定
        $role1 = Role::query()->create([
            'name' => 'user',
        ]);
        $role2 = Role::query()->create([
            'name' => 'author',
        ]);
        $role3 = Role::query()->create([
            'name' => 'admin',
        ]);

        // タグ名の初期設定
        $tag1 = Tag::query()->create([
            'name' => 'php',
        ]);
        $tag2 = Tag::query()->create([
            'name' => 'c++',
        ]);
        $tag3 = Tag::query()->create([
            'name' => 'ruby',
        ]);

        // カテゴリ名の初期設定
        $category = Category::create([
            'name' => 'Education',
            'slug' => 'education'
        ]);

        // ユーザー情報の登録
        $user = $role2->users()->create([
            'name' => 'masahiro',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'status' => 1,
        ]);

        // ユーザー情報の登録
        $admin = $role3->users()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 1,
        ]);

        // 記事情報の登録
        $post = $user->posts()->create([
            'title' => 'This is title',
            'slug' => 'This is slug',
            'excerpt' => 'This is excerpt',
            'body' => 'This is content',
            'category_id' => 1,
        ]);

        // タグと記事のリレーション設定
        $post->tags()->attach([
            $tag1->id, $tag2->id, $tag3->id
        ]);
    }
}
