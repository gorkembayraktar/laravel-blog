<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function(){
    Route::get('giris','Back\Dashboard@login')->name('login');
    Route::post('giris','Back\AuthController@loginPost')->name('login.post');
});

Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function(){
    Route::get('panel','Back\Dashboard@index')->name('dashboard');
    Route::resource('makaleler','Back\ArticleController');
    Route::get('/switch','Back\ArticleController@switch')->name('switch');
    Route::get('cikis','Back\AuthController@logout')->name('logout');     
});



/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', 'Front\Homepage@index')->name('homepage');
Route::get('/kategori/{category}','Front\Homepage@category')->name('kategori');
Route::post('/iletisim','Front\Homepage@contactpost')->name('contact.post');
Route::get('/iletisim','Front\Homepage@contact')->name('contact');
Route::get('/{category}/{slug}','Front\Homepage@single')->name('single');
Route::get('/{sayfa}','Front\Homepage@page')->name('page');


