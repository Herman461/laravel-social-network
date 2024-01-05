<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    private $pagination;
    public function __construct($resource)
    {
        $this->pagination = [
            'currentPage' => $resource->currentPage()
        ];

        $resource = $resource->getCollection(); // Necessary to remove meta and links
        parent::__construct($resource);
    }
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $posts = collect([]);

        $this->collection->each(function(Post $post) use ($posts) {
            $postResource = new PostResource($post);
            $posts->push($postResource);
        });

        return [
            'posts' => $posts,
            'pagination' => $this->pagination
        ];
    }

}
