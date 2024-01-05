<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function upload_avatar(Request $request) {

        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = auth()->user();

        $filename = time() . '.' . $request->avatar->extension();
        $request->avatar->storeAs('public/images/uploads', $filename);

        $user->avatar = $filename;
        $user->save();

        return response(200);
    }
    public function get(string $slug = '') {

//        auth()->loginUsingId(1);

        if (auth()->user() && auth()->user()->slug === $slug) {
            return redirect('/profile', 301);
        }

        $user = User::whereSlug($slug)->first();

        if ( ! auth()->check() ) {
            return redirect('/login');
        }

        $posts = Post::where('user_id', '=', auth()->user()->id)->paginate(5);

        return view('index', ['user' => $user, 'posts' => $posts]);

    }
}
