<?php

use App\Models\User;
use App\Models\category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\AdminCateController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\RoleRequestController;
use App\Http\Controllers\AdminCategoryController;

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
    return view('home', [
        'active' => 'home'
    ]);
});

Route::get('/home', function () {
    return view('home', [
        'active' => 'home'
    ]);
});

Route::get('/game', [CategoryController::class, 'showcategory']);
// Route::get('/users', [CategoryController::class, 'showuserbycategory']);

// Route::get('/users/{id}', [CategoryController::class, 'showuserbycategory']);
// Route::get('/users/{category:slug}', function (category $category) {
//     return view('test', [
//         'category' =>  $category->user
//     ]);
// });

Route::get('/categories/{category:slug}', [CategoryController::class,'showuserbycategory']);
Route::get('/user/{user:username}', [UserController::class,'showsingleuser'])->name('user');

// login
Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

//register
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout',[LogoutController::class,'logout']);

Route::get('/addtocart/{user:username}', [OrderController::class,'index'])->middleware('auth');
Route::resource('/addtocart', OrderController::class)->middleware('auth');


Route::get('/cart/{user:username}', [OrderController::class,'GetCartByUserId'])->middleware('auth');
Route::put('/cart/{id}', [OrderController::class, 'update']);
Route::get('/orderpage/{selectedItems}', 'OrderController@showOrderPage')->name('order.page');

Route::post('/place-order', 'OrderController@placeOrder')->name('place.order');
Route::get('/dashboard', function(){
    return view('admin.index',
    [
        "title" => "Dashboard",
        'active' => 'dashboard'
    ]);
})->middleware('auth');

Route::resource('/role/request', RoleRequestController::class)->middleware('auth');
Route::resource('/dashboard/categories', AdminCategoryController::class)->middleware('auth');
Route::resource('/dashboard/role', AdminRoleController::class)->middleware('auth');

Route::get('/top_up', [TopUpController::class, 'index'])->middleware('auth')->name('top_up');
Route::post('/top_up', [TopUpController::class, 'store'])->middleware('auth')->name('store_top_up');
Route::get('/top_up/sukses', [TopUpController::class, 'sukses']);
