<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

// Admin & Publisher
Route::group(['middleware' => ['auth', 'role:admin,publisher']], function () {
    Route::get('/', 'DashboardController@index');
    Route::resource('/news', 'NewsController')->except(['show']);

    // Uploads
    Route::get('/upload/image', 'UploadController@image_get')->name('upload.image');
    Route::post('/upload/image', 'UploadController@image_create')->name('upload.image');
    Route::delete('/upload/image', 'UploadController@image_delete')->name('upload.image');

    // Settings
    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::post('/settings', 'SettingsController@update')->name('settings');
});

// Only Admin
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::resource('/users', 'UsersController')->except(['show', 'create', 'store', 'destroy']);
    Route::post('/users/update_role', 'UsersController@updateRole');
    Route::post('/news/approve_news', 'NewsController@approveNews');

    Route::resource('/news_comments', 'NewsCommentsController')->except(['show', 'create', 'store', 'edit', 'update']);
    Route::post('/news_comments/approve_comment', 'NewsCommentsController@approveComment');
    Route::resource('/news_categories', 'NewsCategoriesController')->except(['show']);
    Route::resource('/stories', 'StoriesController')->except(['show']);
});
