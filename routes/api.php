<?php


use App\Http\Controllers\AuthContoller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
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
    Route::post('/profile/upload/avatar', 'uploadAvatar')->middleware('auth:sanctum');
    Route::post('/profile/upload/banner', 'uploadBanner')->middleware('auth:sanctum');
    Route::get('/profile/user/{slug?}', 'getUser');
    Route::post('/profile/follow/{user}', 'follow')->middleware('auth:sanctum');
    Route::post('/profile/unfollow/{user}', 'unfollow')->middleware('auth:sanctum');
});

Route::controller(VideoController::class)->group(function () {
    Route::get('/videos/stream/{name}', 'streamVideo');
    Route::get('/videos/{user}', 'getVideos'); // TODO: change url
    Route::get('/videos/comments/{video}', 'getComments');
    Route::get('/videos/new', 'getNewVideos');


    Route::patch('/videos/views/{video}', 'incrementViews');
    Route::post('/videos/like/{video}', 'setLike');
    Route::post('/videos/store', 'store');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/home/videos/new', 'getNewVideos');
    Route::get('/home/videos/trending', 'getTrendingVideos');
    Route::get('/home/tags/trending', 'getTrendingTags');
    Route::get('/home/creators/trending', 'getTrendingCreators');
    Route::get('/home/creators/newly', 'getNewlyCreators');
});

Route::controller(AuthContoller::class)
    ->group(function() {
        Route::post('/auth/login', 'login');
        Route::post('/auth/register', 'register');
        Route::get('/auth/get', 'get');
});


Route::post('/auth/check', function () {
    return response()->json(['status' => 'Authorized'], 200);
})->middleware('auth:sanctum');






