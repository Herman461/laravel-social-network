<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        $currentUser = User::query()->find(1);

        $users->each(function($user) use ($currentUser) {
            if ($user->id === 1) return;

            $currentUser->followers()->attach($user);
        });

        Video::factory(12)->create();
        Comment::factory(10)->create();

        $users->each(function($user) {
            (new Like(['video_id' => 1, 'user_id' => $user->id]))->save();
        });


    }
}
