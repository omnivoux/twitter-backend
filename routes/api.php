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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Passport')->group(function () {    
    Route::post('login', 'AuthController@passportLogin')->name('login');    
    Route::post('register','AuthController@passportRegister');         
    Route::middleware('auth:api')->group(function () {
    Route::post('update', 'AuthController@passportUpdate')->name('tweet');            
    });
});


Route::namespace('Tweeter')->group(function () {        
    Route::middleware('auth:api')->group(function () {
        Route::post('tweet', 'TweetController@tweet')->name('tweet');    
        Route::post('comment', 'TweetController@comment')->name('comment');
        Route::post('delete', 'TweetController@delete')->name('comment');    
        Route::post('react', 'TweetController@react')->name('react');    
        Route::get('tweets', 'TweetController@tweets')->name('tweets');    
    });
});
