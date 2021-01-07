<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/auth')->group(function () {
    Route::post('/login', 'api\v1\AuthController@login');
    Route::post('/register', 'api\v1\AuthController@register');
});

Route::apiResource('dashboard', 'api\v1\DashboardController')->only(['index']);
Route::apiResource('appsettings', 'api\v1\AppSettingsController')->only(['index']);
Route::apiResource('news_categories', 'api\v1\NewsCategoryController')->only(['index']);
Route::get('news_categories/{categoryId}/news', 'api\v1\NewsCategoryController@news');

// News
Route::apiResource('news', 'api\v1\NewsController')->only(['show']);
Route::post('news/search', 'api\v1\NewsController@search');

Route::apiResource('news.comments', 'api\v1\NewsCommentController')->only(['index']);

Route::middleware('auth:api')->group(function () {
    Route::get('news_favorited', 'api\v1\NewsController@favoritedNews');
    Route::post('/news/favorite', 'api\v1\NewsController@favoriteNews');

    Route::apiResource('news.comments', 'api\v1\NewsCommentController')->only(['store']);

    // Profile
    Route::post('/profile/updateprofileimage', 'api\v1\ProfileController@updateProfileImage');
    Route::get('/profile/userinfo', 'api\v1\ProfileController@userInfo');
});
