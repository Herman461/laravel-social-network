<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoCollection;
use App\Http\Resources\VideoCommentsCollection;
use App\Models\Like;
use App\Models\User;
use App\Models\Video;
use App\VideoStream;
use \Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function streamVideo(string $name)
    {
        $filename = Storage::disk('public')->path("videos/$name");
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

    public function getComments(Request $request, Video $video): VideoCommentsCollection|Response
    {
        if ($request->exists('per-page') && $request->exists('page')) {
            $perPage = $request->input('per-page') < 20 ? $request->input('per-page') : 20;

            return new VideoCommentsCollection(
                $video->comments()->paginate(
                    perPage: $perPage,
                    page: $request->input('page')
                )
            );
        }

        return response(status: 400);


    }

    public function getVideos(Request $request, User $user): VideoCollection|Response
    {
        if ($request->exists('per-page') && $request->exists('page')) {
            $perPage = $request->input('per-page') < 20 ? $request->input('per-page') : 20;

            return new VideoCollection(
                $user->videos()->paginate(
                    perPage: $perPage,
                    page: $request->input('page')
                )
            );
        }

        return response(status: 400);

    }
}
