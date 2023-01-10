<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
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

        $role = Role::create([
            'name' => 'author',
        ]);

        $user = $role->users()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'status' => 1,
        ]);

        $user->posts()->create([
            'title' => 'This is title',
            'slug' => 'This is slug',
            'excerpt' => 'This is excerpt',
            'body' => 'This is content',
        ]);
    }
}
