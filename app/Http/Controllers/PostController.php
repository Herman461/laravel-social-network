<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostCollection;
use App\Models\Post;

use App\Models\PostImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class PostController extends Controller
{
    public function store(PostRequest $request): Response
    {
        $post = new Post();

        $post->fill([
            'text' => $request->text,
        ]);


        $addedPost = auth()->user()->posts()->save($post);

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach($images as $file) {

                $name = $file->getClientOriginalName();
                $path = $file->storeAs('images', $name, 'public');

                PostImage::query()->create([
                    'name' => $name,
                    'path' => '/storage/' . $path,
                    'post_id' => $addedPost->id
                ]);

            }
        }


        return response(200);
    }
    public function getMany(): PostCollection {
        $page = $request->get('page') ?: 1;
        $userId = $request->get('id');

        $posts = Post::query()
            ->where('user_id', '=', $userId)
            ->paginate(5, ['*'], 'page', $page);

        return new PostCollection($posts);
    }

    public function incrementViews(Post $post): JsonResponse {
        $post->views += 1;
        $post->save();

        return response()->json([
           'views' => $post->views,
            'id' => $post->id
        ]);
    }
}
