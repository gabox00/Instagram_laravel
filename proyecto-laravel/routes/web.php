<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;

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

Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

//Usuarios
Route::get('/configuracion', [UserController::class, 'config'])->name("config");
Route::post('/user/update', [UserController::class, 'update'])->name("user.update");
Route::get('/user/avatar/{filename}', [UserController::class, 'getImage'])->name("user.avatar");
Route::delete('/image/delete', [UserController::class, 'deleteImage'])->name("image.delete");
Route::get('/profile/{user_id}', [UserController::class, 'profile'])->name("profile");
Route::get('/users/{search?}', [UserController::class, 'index'])->name("users");
Route::get('/followings', [UserController::class, 'followings'])->name("followings");
Route::get('/chat', [UserController::class, 'chat'])->name("chat");

//Imagenes
Route::get('/subir-imagen', [ImageController::class, 'create'])->name("image.create");
Route::post('/image/save', [ImageController::class, 'save'])->name("image.save");
Route::get('/image/file/{filename}', [ImageController::class, 'getImage'])->name("image.file");

//likes
Route::get('/like/{image_id}', [LikeController::class, 'like'])->name("like.save");
Route::get('/dislike/{image_id}', [LikeController::class, 'dislike'])->name("dislike.delete");
Route::get('/likes', [LikeController::class, 'getLikes'])->name("likes");

//Comentarios
Route::post('/comment/save', [CommentController::class, 'save'])->name("comment.save");
Route::post('/comment/delete', [CommentController::class, 'delete'])->name("comment.delete");

//Follows
Route::get('/follow/{following_id}', [FollowController::class, 'follow'])->name("follow");
Route::get('/unfollow/{following_id}', [FollowController::class, 'unfollow'])->name("unfollow");



require __DIR__.'/auth.php';
