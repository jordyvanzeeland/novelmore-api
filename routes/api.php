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
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

/**
 * Challenges routes
 */

Route::get("challenges", 'App\Http\Controllers\ChallengesController@getAllActiveChallenges')->middleware(JwtMiddleware::class);
Route::get("challenges/finished", 'App\Http\Controllers\ChallengesController@getAllFinishedChallenges')->middleware(JwtMiddleware::class);
Route::get("challenge/{id}", 'App\Http\Controllers\ChallengesController@getChallengeByID')->middleware(JwtMiddleware::class);
Route::get("challenge/{id}/books", 'App\Http\Controllers\ChallengesController@getBooksOfChallenge')->middleware(JwtMiddleware::class);
