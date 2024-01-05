<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

use App\Http\Resources\PostCollection;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



//Route::get('/{vue?}', function () {
//    return view('index');
//})->where('vue', '[\/\w\.-]*');

Route::get('{any?}', function () {
    return view('index');
})->where('any',  '^((?!api).)*$');
