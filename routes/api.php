<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\RoleApiController;
use \App\Http\Controllers\Api\UserApiController;
use \App\Http\Controllers\Api\LetterApiController;
use \App\Http\Controllers\Api\NewsApiController;
use \App\Http\Controllers\Api\RequestLetterApiController;

Route::controller(RoleApiController::class)->group(function () {
    Route::get('/roles', 'getRoles');
    Route::get('/roles/{id}', 'getRoleById');
});

Route::controller(LetterApiController::class)->group(function () {
    Route::get('/letters', 'getLetters');
    Route::get('/letters/{id}', 'getLetterById');
});

Route::controller(UserApiController::class)->group(function () {
    Route::get('/users', 'getUsers');
    Route::get('/users/{userId}', 'getUserById');
    Route::post('/register-user', 'register');
    Route::post('/login-user', 'login');
    Route::post('/forgot-pass-user', 'forgotPassword');
    Route::post('/edit-user/{userId}', 'updateProfile');
    Route::post('/delete-user/{userId}', 'deleteUserById');
});

Route::controller(NewsApiController::class)->group(function () {
    Route::get('/news', 'getNews');
    Route::get('/news/{id}', 'getNewsById');
    Route::post('/delete-news/{id}', 'deleteNewsById');
    Route::post('/update-news/{id}', 'updateNews');
    Route::post('/create-news', 'createNews');
});

Route::controller(RequestLetterApiController::class)->group(function () {
    Route::get('/req-letters', 'getRequestLetters');
    Route::get('/req-letters/{userId}', 'getRequestLettersByUserId');
    Route::get('/req-letters/{id}', 'getRequestLetterById');
    Route::post('/create-req-letters', 'createRequestLetter');
    Route::post('/update-req-letters/{id}', 'updateRequestLetter');
    Route::post('/delete-req-letters/{id}', 'deleteRequestLetterById');
});



