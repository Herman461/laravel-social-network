<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VideoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = collect([]);

        $this->collection->each(function ($video) use ($response) {
            $result = collect([
                'video' => $video,
                'likes_count' => $video->likes()->count(),
                'comments_count' => $video->comments()->count(),
                'comments' => []
            ]);

            $response->add($result);
        });

        return $response->toArray();
    }
}
