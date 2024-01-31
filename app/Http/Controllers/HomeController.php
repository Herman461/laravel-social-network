<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoCollection;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function getNewVideos(Request $request)
    {
        return new VideoCollection(
           Video::query()
               ->take(15)
               ->get()
        );
    }

    public function getTrendingTags(Request $request)
    {
        return DB::table('tag_video')
            ->select('tag_id', 'tags.slug', 'tags.name', DB::raw('count(*) as tag_count'))
            ->join('tags', 'tags.id', '=', 'tag_video.tag_id')
            ->groupBy('tag_id')
            ->orderBy('tag_count', 'desc')
            ->take(30)
            ->get();
    }

    public function getTrendingCreators(Request $request)
    {
        return DB::table('users')
            ->select('*', DB::raw('SUM(views) AS view_count'))
            ->whereBetween('videos.created_at', [date("Y-m-d", strtotime("-1 month")), now()])
            ->join('videos', 'users.id', '=', 'videos.user_id')
            ->groupBy('videos.user_id')
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();
    }

    // TODO: Дописать запрос на получение новых пользователей, у которых есть аватарка и у которых подписчиков от 10 до 100
    public function getNewlyCreators(Request $request)
    {
//        return DB::table('users')
//            ->select('*', DB::raw('COUNT(follower_id) AS follower_count'))
//            ->whereBetween('users.created_at', [date("Y-m-d", strtotime("-1 month")), now()])
////            ->whereBetween('users.')
//            ->join('author_follower', 'author_follower.follower_id', '=', 'users.id')
//            ->groupBy('users.id')
//            ->orderBy('follower_count', 'desc')
//            ->take(5)
//            ->get();
    }


    public function getTrendingVideos(Request $request)
    {
        return new VideoCollection(
            Video::query()
                ->whereBetween('created_at', [date("Y-m-d", strtotime("-7 days")), now()])
                ->orderBy('views', 'desc')
                ->take(15)
                ->get()
        );

    }
//        return DB::table('videos')
//            ->select('*')
//            ->whereBetween('created_at', [date("Y-m-d", strtotime("-7 days")), now()])
//            ->groupBy('user_id')
//            ->orderBy('views', 'desc')
//            ->take(20)
//            ->get();

}
