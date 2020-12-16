<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAge;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KindController;

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
    return view('home1');
});
Route::get('/404', function () {
    return view('errors/404');
});

//Main
Route::get('/users', function () {
    return view('user/users');
});
Route::get('/profiles', function () {
    return view('profile/profiles');
});
Route::get('/kinds', function () {
    return view('kind/list');
});
Route::get('/orders', function () {
    return view('order/list');
});
Route::get('/products', function () {
    return view('product/list');
});
Route::get('/check_fail', function (){
    echo "check_fail page";
    return view('home');
});
Route::get('check_age/{age?}', function ($age) {
    echo $age;
    return view('home');
})->middleware(CheckAge::class);

//
Route::resource('users', UserController::class);
Route::get('users/show/{id}', [UserController::class, 'show']);
Route::resource('profiles', ProfileController::class);
Route::get('profiles/show/{id}', [ProfileController::class, 'show']);

Route::resource('orders', OrderController::class);
Route::get('orders/show/{id}', [OrderController::class, 'show']);
Route::resource('products', ProductController::class);
Route::resource('kinds', KindController::class);

//api ajax
Route::post('/checkmail',[UserController::class, 'checkEmail'])->name('user.checkEmail');
Route::post('/getUser',[UserController::class, 'getUser'])->name('user.getUser');
Route::post('/getprofile',[ProfileController::class, 'getProfile'])->name('profile.getProfile');
Route::post('/postprofile',[ProfileController::class, 'postProfile'])->name('profile.postProfile');
Route::post('/getKinds',[KindController::class, 'getKinds'])->name('kind.getKinds');
Route::post('/orders/show/postitem',[OrderController::class, 'postBuyItem'])->name('order.postBuyItem');
Route::post('/orders/show/postorder',[OrderController::class, 'postOrder'])->name('order.postOrder');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
