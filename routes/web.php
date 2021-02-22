<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/admin/panel','Back\Dashboard@index')->name('admin.dashboard');
Route::get('/admin/giris','Back\Dashboard@login')->name('admin.login');
Route::post('/admin/giris','Back\AuthController@loginPost')->name('admin.login.post');
Route::get('/admin/cikis','Back\AuthController@logout')->name('admin.logout');
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


