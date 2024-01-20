<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Response;
use App\VideoStream;

class ProfileController extends Controller
{
    public function uploadAvatar(Request $request): JsonResponse {

        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:5096'
        ]);

        $user = auth()->user();

        if (
            isset($user->avatar)
            && Storage::disk('public')->exists('images/uploads/' . $user->avatar)
        ) {
            Storage::disk('public')->delete('images/uploads/' . $user->avatar);
        }

        $filename = time() . '.' . $request->avatar->extension();
        $request->avatar->storeAs('public/images/uploads', $filename);

        $user->avatar = $filename;
        $user->save();

        return response()->json([
            'avatar' => $filename
        ]);
    }

    public function uploadBanner(Request $request): JsonResponse {

        $request->validate([
            'banner' => 'required|image|mimes:jpg,jpeg,png|max:5096'
        ]);

        $user = auth()->user();

        if (
            isset($user->banner)
            && Storage::disk('public')->exists('images/uploads/' . $user->banner)
        ) {
            Storage::disk('public')->delete('images/uploads/' . $user->banner);
        }

        $filename = time() . '.' . $request->banner->extension();
        $request->banner->storeAs('public/images/uploads', $filename);

        $user->banner = $filename;
        $user->save();

        return response()->json([
            'banner' => $filename
        ]);
    }


    public function getUser(Request $request, string $slug = ''): UserResource|JsonResponse
    {

        $token = PersonalAccessToken::findToken($request->bearerToken());

        $authUser = $token?->tokenable;

        if (!$authUser && $slug === '') {
            return response()->json([
                'message' => 'Unauthorized.'
            ], 401);
        }

        $isFollower = false;

        if (empty($slug)) {
            $canEditProfile = true;
        } else {
            $user = User::query()->where('slug', '=', $slug)->withCount('followers')->first();

            if (isset($authUser)) {
                $isFollower = DB::table('author_follower')
                        ->whereAuthorId($user->id)
                        ->whereFollowerId($authUser->id)
                        ->count() > 0;
            }

        }

        $profileUser = $user ?? $authUser;

        return (new UserResource($profileUser))
            ->additional(
                ['canEditProfile' => isset($canEditProfile), 'isFollower' => $isFollower]
            );

    }

    public function follow(User $user)
    {
        $user->followers()
            ->attach( auth()->user() );

        return response()->json([
           'isFollower' => true
        ]);
    }

    public function unfollow(User $user)
    {
        $user->followers()
            ->detach( auth()->user() );

        return response()->json([
            'isFollower' => false
        ]);
    }
//    public function get(string $slug = '') {
//
////        auth()->loginUsingId(1);
//
//        if (auth()->user() && auth()->user()->slug === $slug) {
//            return redirect('/profile', 301);
//        }
//
//        $user = User::whereSlug($slug)->first();
//
//        if ( ! auth()->check() ) {
//            return redirect('/login');
//        }
//
//        $posts = Post::where('user_id', '=', auth()->user()->id)->paginate(5);
//
//        return view('index', ['user' => $user, 'posts' => $posts]);
//
//    }

}
