<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VideoCommentsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = collect([]);

        $this->collection->each(function ($comment) use ($response) {
            $result = collect([
                'comment' => $comment,
                'user' => $comment->user
            ]);

            $response->add($result);
        });

        return $response->toArray();
    }
}
