<?php


use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Resources\PostCollection;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth/create', function () {

});
Route::view('/login', 'login');

Route::controller(ProfileController::class)->group(function () {
    Route::post('/upload/avatar', 'upload_avatar');
//    Route::get('/profile/{slug?}', 'get');
});


Route::controller(PostController::class)
    ->group(function () {
//        Route::post('/post/store', 'store')->name('post.store')->middleware('auth');
        Route::post('/post/store', 'store')->name('post.store');
        Route::patch('/post/{post}/views/', 'incrementViews')->name('patch.views.increment')->middleware('auth');
        Route::get('/posts', 'getMany');
        Route::get('/post', 'getOne');

    });

Route::get('/search/random/users', function () {
    return DB::table('users')
        ->select('*')
        ->limit(5)
        ->inRandomOrder()
        ->get();
});

Route::post('/auth', function () {

    auth()->loginUsingId(1);
});


Route::get('/profile/user/{slug}', function ($slug) {
    $user = User::whereSlug($slug)->get();
    return $user;
});

Route::get('/auth/check', function () {
    if (auth('api')->check()) {
        return 'ok!';
    } else {
        return 'unauthorized';
    }
});




