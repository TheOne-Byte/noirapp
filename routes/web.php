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
    return view('welcome');
});

Route::get('/home', function () {
    return view('home',[
        'active' => 'home'
    ]);
    
});

Route::get('/game', [CategoryController::class,'showcategory']);
// Route::get('/users', [CategoryController::class,'showuserbycategory']);

// Route::get('/users/{id}', [CategoryController::class,'showuserbycategory']);
// Route::get('/users/{category:slug}', function(category $category){
//     return view('test',[
//         'category' =>  $category->user
//     ]);
// });

Route::get('/categories/{category:slug}', [CategoryController::class,'showuserbycategory']);
Route::get('/user/{user:username}', [UserController::class,'showsingleuser'])->name('user');

// login
Route::get('/login', [LoginController::class,'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class,'authenticate']);

//register
Route::get('/register', [RegisterController::class,'index'])->middleware('guest');
Route::post('/register', [RegisterController::class,'register']);

Route::post('/logout',[LogoutController::class,'logout']);

Route::get('/addtocart/{user:username}', [OrderController::class,'index'])->middleware('auth');


Route::resource('/addtocart', OrderController::class)->middleware('auth');
Route::get('/cart/{user:username}', [OrderController::class,'GetCartByUserId'])->middleware('auth');


