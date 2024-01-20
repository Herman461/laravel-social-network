<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Video;
use App\VideoStream;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function streamVideo()
    {
        $filename = Storage::disk('public')->path("videos/01.mp4");
        $stream = new VideoStream($filename);
        $stream->start();


    }
    public function incrementViews(Video $video)
    {
        $video->views += 1;
        $video->save();
    }

    public function setLike(Video $video)
    {
        (new Like(['user_id' => 1, 'video_id' => $video->id]))->save();

    }

    public function addComment(Video $video)
    {

    }

    public function getVideo(Video $video)
    {
        return response()->json([
           'likes_count' => $video->likes()->count(),
           'comments_count' => $video->comments()->count()
        ]);
    }
}
