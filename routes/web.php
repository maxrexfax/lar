<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserslistController;
use App\Http\Controllers\MessageController;
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

Route::view('/', 'welcome')->name('root');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home.show.rout');

Route::get('/userslist', [UserslistController::class, 'index'])->name('userslist');

Route::get('/userslist/command', [UserslistController::class, 'command'])->name('userslist.command');

Route::get('/userslist/show', [UserslistController::class, 'show'])->name('userslist.show');

Route::post('/userslist/create', [UserslistController::class, 'create'])->name('userslist.create');

Route::match(['get', 'post'],'/userslist/edit', [UserslistController::class, 'edit'])->name('userslist.edit');

Route::post('/userslist/editsave', [UserslistController::class, 'editsave'])->name('userslist.editsave');

Route::get('/userslist/destroy', [UserslistController::class, 'destroy'])->name('userslist.destroy');

Route::get('/userslist/filter', [UserslistController::class, 'filteruserslist'])->name('userslist.filter');

Route::get('/usercreate', [UserslistController::class, 'createnewuser'])->name('usercreate');

Route::match(['get'], '/messages', [MessageController::class, 'index'])->name('messages');

Route::match(['get', 'post'], '/messages/create', [MessageController::class, 'create'])->name('messages.create');

Route::match(['get', 'post'], '/messages/show', [MessageController::class, 'show'])->name('messages.show');
