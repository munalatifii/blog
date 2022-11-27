<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' =>'auth',
'prefix'=>'blogs',
'as'=>'blogs.'
],function(){
Route::get('/', [App\Http\Controllers\BlogController::class, 'index'])->name('index');
Route::get('/create', [App\Http\Controllers\BlogController::class, 'create'])->name('create');
Route::post('/create', [App\Http\Controllers\BlogController::class, 'store'])->name('store');
Route::get('/{blog}', [App\Http\Controllers\BlogController::class, 'show'])->name('show');
Route::get('/blogs/{blog}/edit', [App\Http\Controllers\BlogController::class, 'edit'])->name('edit');
Route::post('/{blog}/edit', [App\Http\Controllers\BlogController::class, 'update'])->name('update');
Route::get('/{blog}/delete', [App\Http\Controllers\BlogController::class, 'delete'])->name('delete');

});



