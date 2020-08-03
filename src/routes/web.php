<?php

use App\Jobs\ListOfFavorites;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::prefix('/favorites')->group(function () {
    Route::get('/', 'FavoritesController@index')->name('favorites');
    Route::post('/add', 'FavoritesController@add')->name('add.favorite');
    Route::delete('/remove', 'FavoritesController@remove')->name('remove.favorite');
});

Route::get('envio-email', function(){
    $user = Auth::user();

    ListOfFavorites::dispatch($user)->delay(now()->addMinutes(2));
});
