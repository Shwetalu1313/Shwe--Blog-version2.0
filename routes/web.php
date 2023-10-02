<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::resource('/', WelcomeController::class);
Route::resource('explore/', ExploreController::class);

Auth::routes();

Route::get(
    'feedback/', function (){
        return view('feedback');
}
);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('/user', UserController::class);
    Route::resource('category', CategoryController::class);
    Route::post('/category/pass', [CategoryController::class, 'passvalidator'])->name('passvalidator');
    Route::put('/user/update/image/{user}', [UserController::class, 'imgupdate'])->name('updateProfileImage');
    Route::resource('comments',CommentController::class);
    Route::post('/mail/send', [MailController::class, 'send'])->name('mail.send');
});

Route::resource('/posts',PostController::class);




