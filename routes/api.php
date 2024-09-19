<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;

/**
 * Authentication routes
 */

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
});

/**
 * Challenges routes
 */

Route::get("challenges", 'App\Http\Controllers\ChallengesController@getAllActiveChallenges')->middleware(JwtMiddleware::class);
Route::get("challenges/finished", 'App\Http\Controllers\ChallengesController@getAllFinishedChallenges')->middleware(JwtMiddleware::class);
Route::get("challenge/{id}", 'App\Http\Controllers\ChallengesController@getChallengeByID')->middleware(JwtMiddleware::class);
Route::get("challenge/{id}/books", 'App\Http\Controllers\ChallengesController@getBooksOfChallenge')->middleware(JwtMiddleware::class);
Route::post("challenge/{id}/book/insert", 'App\Http\Controllers\ChallengesController@insertBookToChallenge')->middleware(JwtMiddleware::class);
Route::delete("challenge/{id}/book/{bookid}/delete", 'App\Http\Controllers\ChallengesController@deleteBookFromChallenge')->middleware(JwtMiddleware::class);
