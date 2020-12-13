<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAge;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', function () {
    return view('home');
});
Route::get('/signup', function () {
    return view('signup');
});
Route::get('/status', function () {
    return view('status');
});
Route::get('/contact', function () {
    return view('contact');
});
Route::get('/users', function () {
    $users = DB::table('users')->get();
    return view('user/users',  ['users' => $users]);
});
Route::get('/profiles', function () {
    $profiles = DB::table('profiles')->get();
    return view('profile/profiles',  ['profiles' => $profiles]);
});
Route::get('/check_fail', function (){
    echo "check_fail page";
    return view('home');
});
Route::get('check_age/{age?}', function ($age) {
    echo $age;
    return view('home');
})->middleware(CheckAge::class);
Route::resource('users', UserController::class);
Route::get('user/users/{id}', [UserController::class, 'show']);
Route::resource('profiles', ProfileController::class);
Route::get('profiles/{id}', [ProfileController::class, 'show']);

Route::post('/checkmail',[UserController::class, 'checkEmail'])->name('user.checkEmail');
Route::post('/getprofile',[ProfileController::class, 'getProfile'])->name('profile.getProfile');
Route::post('/postprofile',[ProfileController::class, 'postProfile'])->name('profile.postProfile');