<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(rand(3, 6))->create()->each(function ($user) {
            Post::factory(rand(2, 4))->create(['user_id' => $user->id]);
        });
    }
}
