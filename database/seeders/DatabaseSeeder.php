<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Tag;
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
        $users = User::factory(100)->create();

//        $currentUser = User::query()->find(1);

        $users->each(function($user) {
//            if ($user->id === 1) return;

            $followers = User::query()
                ->where('id', '!=', $user->id)
                ->inRandomOrder(random_int(1, 100))
                ->get()
                ->map(function($follower) {
                    return $follower->id;
                });

            $user->followers()->attach($followers);

        });

        $videos = Video::factory(1000)->create();
        Comment::factory(10)->create();

        $users->each(function($user) {
            (new Like(['video_id' => 1, 'user_id' => $user->id]))->save();
        });

        $tags = Tag::factory(40)->create()->map(function (Tag $tag) {
            return $tag->id;
        });

        $videos->each(function($video) use ($tags) {
           $video->tags()->attach($tags->random(3)->toArray());
        });
    }
}
