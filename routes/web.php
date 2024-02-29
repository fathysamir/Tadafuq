<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\website\PostController;
use App\Http\Controllers\website\AuthController;
use App\Http\Controllers\website\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
    //Route::get('/register', [AuthController::class, 'register_view'])->name('register.view');
    //Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login', [AuthController::class, 'login_view'])->name('login.view');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
   
    Route::group(['middleware' => ['admin']], function () {
        // ==================================  Home   ==================================
        Route::any('/', [PostController::class, 'index'])->name('home');
        
        Route::get('/post/view/{id}', [PostController::class, 'show'])->name('view.post');
        Route::get('/posts/create', [PostController::class, 'create'])->name('add.post');
        Route::post('/posts/create', [PostController::class, 'store'])->name('create.post');
        Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('edit.post');
        Route::post('/post/update/{id}', [PostController::class, 'update'])->name('update.post');
        Route::get('/post/delete/{id}', [PostController::class, 'delete'])->name('delete.post');

        // ==================================  Users   ==================================
        Route::any('/users', [UserController::class, 'index'])->name('users');
        
        
        Route::get('/users/create', [UserController::class, 'create'])->name('add.user');
        Route::post('/users/create', [UserController::class, 'store'])->name('create.user');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('edit.user');
        Route::post('/user/update/{id}', [UserController::class, 'update'])->name('update.user');
        Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('delete.user');


        //===================================  logout  =======================================
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });