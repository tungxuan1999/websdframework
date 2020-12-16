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

Route::get('/home', function () {
    return view('home1');
})->middleware(['auth','role:viewer']);
Route::get('/error.404', function () {
    return view('errors/404');
});

//Main
Route::get('/users', function () {
    return view('user/users');
})->middleware(['auth','role:admin']);
Route::get('/profiles', function () {
    return view('profile/profiles');
})->middleware(['auth','role:admin']);
Route::get('/kinds', function () {
    return view('kind/list');
})->middleware(['auth','role:editor']);
Route::get('/orders', function () {
    return view('order/list');
})->middleware(['auth','role:editor']);
Route::get('/products', function () {
    return view('product/list');
})->middleware(['auth','role:editor']);
Route::get('/check_fail', function (){
    echo "check_fail page";
    return view('home1');
});
Route::get('check_age/{age?}', function ($age) {
    echo $age;
    return view('home1');
})->middleware(CheckAge::class);

//
Route::resource('users', UserController::class)->middleware(['auth','role:admin']);
Route::get('users/show/{id}', [UserController::class, 'show'])->middleware(['auth','role:viewer']);
Route::resource('profiles', ProfileController::class)->middleware(['auth','role:admin']);
Route::get('profiles/show/{id}', [ProfileController::class, 'show'])->middleware(['auth','role:viewer']);
Route::get('myprofileupload', [ProfileController::class, 'showmyprofile'])->middleware(['auth','role:viewer']);


Route::resource('orders', OrderController::class)->middleware(['auth','role:editor']);
Route::get('orders/show/{id}', [OrderController::class, 'show'])->middleware(['auth','role:editor']);
Route::resource('products', ProductController::class)->middleware(['auth','role:editor']);
Route::resource('kinds', KindController::class)->middleware(['auth','role:editor']);

//api ajax
Route::post('/checkmail',[UserController::class, 'checkEmail'])->name('user.checkEmail');
Route::post('/getUser',[UserController::class, 'getUser'])->name('user.getUser');
Route::post('/getprofile',[ProfileController::class, 'getProfile'])->name('profile.getProfile');
Route::post('/postprofile',[ProfileController::class, 'postProfile'])->name('profile.postProfile');
Route::post('/postmyprofile',[ProfileController::class, 'postMyProfile'])->name('profile.postMyProfile');
Route::post('/getKinds',[KindController::class, 'getKinds'])->name('kind.getKinds');
Route::post('/orders/show/postitem',[OrderController::class, 'postBuyItem'])->name('order.postBuyItem');
Route::post('/orders/show/postorder',[OrderController::class, 'postOrder'])->name('order.postOrder');
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');