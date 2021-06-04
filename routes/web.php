<?php

use App\Events\onUserBootEvent;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserslistController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\DeviceController;
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
Route::get('send', [HomeController::class, 'sendNotification']);
//Route::view('/', 'welcome')->name('root');
//Два закоменченых примера ниже это альтернатива кода на строке 31 - походу лучше код на стр 31
//Route::get('/{var0?}/{var00?}', [HomeController::class, 'index'])->name('home.show.rout');
//Route::get('/{var0?}', [HomeController::class, 'index'])->name('home.show.rout');
Route::get('/', [HomeController::class, 'index'])->name('home.show.rout');
Route::get('/test', [HomeController::class, 'test'])->name('home.test.rout');
Route::get('/listfiles', [HomeController::class, 'listFiles']);
Route::get('/download/{var?}', [HomeController::class, 'download']);
Route::get('/resp/{var?}', [HomeController::class, 'resp']);
Route::get('/serialize/{var?}', [HomeController::class, 'serialize']);
Route::match(['get', 'post'], '/upload', [HomeController::class, 'upload'])->name('file.upload');


Auth::routes();


Route::get('/usercreate', [UserslistController::class, 'createform'])->name('createform');

Route::prefix('/users')->group(function() {
    Route::prefix('/list')->group(function () {
        Route::get('/{var1?}/{var2?}', [UserslistController::class, 'index'])->name('userslist');
        Route::get('/changeHealthStatus', [UserslistController::class, 'changeHealthStatus'])->name('userslist.changeHealthStatus');
        Route::get('/show', [UserslistController::class, 'show'])->name('userslist.show');
        Route::get('/create', [UserslistController::class, 'create'])->name('userslist.create');
        Route::post('/store', [UserslistController::class, 'store'])->name('userslist.store');
        Route::match(['post', 'get'],'/edit', [UserslistController::class, 'edit'])->name('userslist.edit');
        Route::post('/save', [UserslistController::class, 'save'])->name('userslist.save');
        Route::get('/destroy', [UserslistController::class, 'destroy'])->name('userslist.destroy');
        Route::get('/filter', [UserslistController::class, 'filteruserslist'])->name('userslist.filter');
        Route::get('/maplist', [UserslistController::class, 'maplist'])->name('userslist.maplist');
        Route::match(['get', 'post'],'/mapsave', [UserslistController::class, 'mapsave'])->name('userslist.mapsave');
        //Route::get('test', [UserslistController::class, 'testReplicating']);
    });

    Route::get('/map', [UserslistController::class, 'map'])->name('userslist.map');
    Route::get('/mapadd', [UserslistController::class, 'mapadd'])->name('userslist.mapadd');
});

Route::prefix('/messages')->group(function (){
    Route::get( '', [MessageController::class, 'index'])->name('messages');
    Route::get( 'create', [MessageController::class, 'create'])->name('messages.create');
    Route::get( 'show', [MessageController::class, 'show'])->name('messages.show');
    Route::get( 'showCount', [MessageController::class, 'showCount'])->name('messages.showCount');
});


Route::prefix('/devices')->group(function (){
    Route::get( '', [DeviceController::class, 'index'])->name('devices');
    Route::get( 'list', [DeviceController::class, 'list'])->name('devices.list');
    Route::match(['get', 'post'], 'use', [DeviceController::class, 'use'])->name('devices.use');
    Route::get( 'administration', [DeviceController::class, 'administration'])->name('devices.administration');
});

Route::match(['get', 'post'], '/chat', [HomeController::class, 'chat']);

Route::post('sendmessage', 'chatController@sendMessage');

Route::get('/fire', function () {
    event(new onUserBootEvent());
    return 'ok';
});
