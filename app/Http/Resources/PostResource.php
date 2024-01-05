<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->comments()->each(function (Comment $comment) use ($comments) {

            $replies = collect([]);

            $comment->replies()->each(function (Comment $reply) use ($replies) {

                $replies->push([
                    'user' => $reply->user,
                    'comment' => $reply
                ]);

            });

            $comments->push([
                'user' => $comment->user,
                'comment' => $comment,
                'replies' => $replies
            ]);
        });

        return [
            'post' => $post,
            'comments' => $comments,
            'user' => $post->user
        ];
    }
}
