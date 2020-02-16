<?php

use Illuminate\Http\Request;

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

Route::post('login', 'Backend\Auth\LoginController@login');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('dashboard', 'Backend\DashboardController@index');
    Route::post('change-password', 'Backend\DashboardController@changePassword');

    /**
     * Chapter Routes
     */
    Route::group(['prefix' => 'chapters'], function() {
       Route::get('/', 'Backend\ChapterController@index');
       Route::get('{id}', 'Backend\ChapterController@show');
       Route::post('store', 'Backend\ChapterController@store');
       Route::post('update', 'Backend\ChapterController@update');
       Route::delete('delete/{id}', 'Backend\ChapterController@destroy');
       Route::get('dependency/data', 'Backend\ChapterController@dependency');
       Route::post('update/image/{id}', 'Backend\ChapterController@updateImage');
    });

    /**
     * Sentence Routes
     */
    Route::group(['prefix' => 'sentences'], function() {
        Route::get('/', 'Backend\SentenceController@index');
        Route::get('{id}', 'Backend\SentenceController@show');
        Route::post('store', 'Backend\SentenceController@store');
        Route::post('update', 'Backend\SentenceController@update');
        Route::delete('delete/{id}', 'Backend\SentenceController@destroy');
        Route::get('dependency/data', 'Backend\SentenceController@dependency');
    });

    /**
     * Word Routes
     */
    Route::group(['prefix' => 'words'], function() {
        Route::get('/', 'Backend\WordController@index');
        Route::get('{id}', 'Backend\WordController@show');
        Route::post('store', 'Backend\WordController@store');
        Route::post('update', 'Backend\WordController@update');
        Route::delete('delete/{id}', 'Backend\WordController@destroy');
        Route::get('dependency/data', 'Backend\WordController@dependency');
    });

    /**
     * Language Routes
     */
    Route::group(['prefix' => 'languages'], function() {
        Route::get('/', 'Backend\LanguageController@index');
        Route::get('{id}', 'Backend\LanguageController@show');
        Route::post('store', 'Backend\LanguageController@store');
        Route::post('update', 'Backend\LanguageController@update');
        Route::delete('delete/{id}', 'Backend\LanguageController@destroy');
    });

    /**
     * Admin Role Routes
     */
    Route::group(['prefix' => 'admin-roles'], function() {
        Route::get('/', 'Backend\AdminRoleController@index');
        Route::get('{id}', 'Backend\AdminRoleController@show');
        Route::post('store', 'Backend\AdminRoleController@store');
        Route::post('update', 'Backend\AdminRoleController@update');
        Route::delete('delete/{id}', 'Backend\AdminRoleController@destroy');
        Route::get('dependency/data', 'Backend\AdminRoleController@dependency');
    });

    /**
     * Admin Routes
     */
    Route::group(['prefix' => 'admins'], function() {
        Route::get('/', 'Backend\AdminController@index');
        Route::get('{id}', 'Backend\AdminController@show');
        Route::post('store', 'Backend\AdminController@store');
        Route::post('update', 'Backend\AdminController@update');
        Route::delete('delete/{id}', 'Backend\AdminController@destroy');
        Route::get('dependency/data', 'Backend\AdminController@dependency');
    });

    /**
     * Country Routes
     */
    Route::group(['prefix' => 'countries'], function() {
        Route::get('/', 'Backend\CountryController@index');
        Route::get('{id}', 'Backend\CountryController@show');
        Route::post('store', 'Backend\CountryController@store');
        Route::post('update', 'Backend\CountryController@update');
        Route::delete('delete/{id}', 'Backend\CountryController@destroy');
    });

    /**
     * User Routes
     */
    Route::group(['prefix' => 'users'], function() {
        Route::get('/', 'Backend\UserController@index');
        Route::get('{id}', 'Backend\UserController@show');
        Route::post('store', 'Backend\UserController@store');
        Route::post('update', 'Backend\UserController@update');
        Route::delete('delete/{id}', 'Backend\UserController@destroy');
        Route::get('dependency/data', 'Backend\UserController@dependency');
    });

    /**
     * Page Routes
     */
    Route::group(['prefix' => 'pages'], function() {
        Route::get('/', 'Backend\PageController@index');
        Route::get('{id}', 'Backend\PageController@show');
        Route::post('store', 'Backend\PageController@store');
        Route::post('update', 'Backend\PageController@update');
        Route::delete('delete/{id}', 'Backend\PageController@destroy');
        Route::get('dependency/data', 'Backend\PageController@dependency');
        Route::post('update/image/{id}', 'Backend\PageController@updateImage');
    });

    /**
     * Blog Routes
     */
    Route::group(['prefix' => 'blogs'], function() {
        Route::get('/', 'Backend\BlogController@index');
        Route::get('{id}', 'Backend\BlogController@show');
        Route::post('store', 'Backend\BlogController@store');
        Route::post('update', 'Backend\BlogController@update');
        Route::delete('delete/{id}', 'Backend\BlogController@destroy');
    });
});
