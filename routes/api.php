<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/verification_register', [AuthController::class, 'verify_register'])->name('verification_register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/log_requests', [AuthController::class, 'get_today_log'])->name('log_requests');


Route::middleware('auth:api')->group( function () {
	  Route::any('/index', [PostController::class, 'index'])->name('home');
	  Route::post('/posts/create', [PostController::class, 'store'])->name('create.post');
	  Route::post('/post/update', [PostController::class, 'update'])->name('update.post');
	  Route::post('/post/delete', [PostController::class, 'delete'])->name('delete.post');
	  Route::get('/post/view', [PostController::class, 'show'])->name('view.post');
	  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
      //////////////////////////////////////
      Route::get('/profile', [ProfileController::class, 'user_profile'])->name('user_profile');

	});


