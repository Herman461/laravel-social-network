<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();
//        Post::factory(10)->create()
//            ->each(function ($post) {
//
//                $comments = Comment::factory( rand( 0, 5 ) )->make();
//
//                $post->comments()->createMany( $comments->toArray() );
//
//                $post->comments()->each(function($comment) {
//                    $replies = Comment::factory( rand( 0, 5 ) )->make();
//
//                    $comment->replies()->createMany($replies->toArray());
//                });
//            });
//


    }
}
