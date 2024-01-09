<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;

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

    public function getUser(Request $request, string $slug = ''): JsonResponse
    {


        if (empty($slug)) {

            $token = PersonalAccessToken::findToken($request->bearerToken());
            if (!isset($token->tokenable)) {
                return response()->json([
                   'message' => 'Unauthorized.'
                ], 401);
            }
            $user = $token->tokenable;

            return response()->json([
                'user' => $user,
                'isAuth' => true
            ]);
        } else {
            $user = User::query()->where('slug', '=', $slug)->first();

            return response()->json([
                'user' => $user,
                'isAuth' => false
            ]);
        }


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
