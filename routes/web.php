<?php

use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyMemberMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequestLetterController;
use App\Http\Controllers\DataWargaController;
use Illuminate\Support\Facades\Storage;

Route::fallback(function () {
    return view('empty');
});

Route::get('/login', [LoginController::class, 'index'])
    ->name('login')
    ->middleware([OnlyGuestMiddleware::class]);

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post')
    ->middleware([OnlyGuestMiddleware::class]);

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware([OnlyMemberMiddleware::class]);

Route::get('/logout', [DashboardController::class, 'logout'])
    ->name('dashboard.logout')
    ->middleware([OnlyMemberMiddleware::class]);

Route::post('/news-delete/{id}', [NewsController::class, 'deleteNewsById'])
    ->name('news.delete')
    ->middleware([OnlyMemberMiddleware::class]);

Route::post('/news-show/{id}', [NewsController::class, 'showNewsById'])
    ->name('news.show')
    ->middleware([OnlyMemberMiddleware::class]);

Route::post('/news-update/{id}', [NewsController::class, 'updateNewsById'])
    ->name('news.update')
    ->middleware([OnlyMemberMiddleware::class]);

Route::post('/news-create', [NewsController::class, 'createNews'])
    ->name('news.create')
    ->middleware([OnlyMemberMiddleware::class]);

Route::post('/profile-editable', [ProfileController::class, 'editableProfile'])
    ->name('profile.edit')
    ->middleware([OnlyMemberMiddleware::class]);

Route::post('/profile-update/{id}', [ProfileController::class, 'updateProfile'])
    ->name('profile.update')
    ->middleware([OnlyMemberMiddleware::class]);

Route::post('/users/{id}', [UserController::class, 'showUserById'])
    ->name('users.show')
    ->middleware([OnlyMemberMiddleware::class]);

Route::get('/search-warga', [DataWargaController::class, 'searchWarga'])
    ->name('searchWarga');

Route::post('/warga/{id}', [DataWargaController::class, 'showDataWargaById'])
    ->name('warga.show');

    Route::get('/warga', [DashboardController::class, 'getWargaPage'])->name('nama_route_ke_warga');


    
Route::post('/warga-update/{id}', [DataWargaController::class, 'updateWargaByid'])
->name('warga.update')
->middleware([OnlyMemberMiddleware::class]);

Route::post('/warga-delete/{id}', [DataWargaController::class, 'deleteWargaById'])
->name('warga.delete')
->middleware([OnlyMemberMiddleware::class]);

Route::post('/warga-add', [DataWargaController::class, 'tambahWarga'])
->name('warga.add')
->middleware([OnlyMemberMiddleware::class]);

    


Route::post('/users-delete/{id}', [UserController::class, 'deleteUserById'])
    ->name('users.delete')
    ->middleware([OnlyMemberMiddleware::class]);

Route::post('/users-update/{id}', [UserController::class, 'updateUserById'])
    ->name('users.update')
    ->middleware([OnlyMemberMiddleware::class]);

Route::post('/req-letters/{id}', [RequestLetterController::class, 'showReqLetterById'])
    ->name('req-letter.show')
    ->middleware([OnlyMemberMiddleware::class]);

Route::post('/req-letters-delete/{id}', [RequestLetterController::class, 'deleteReqLetterById'])
    ->name('req-letter.delete')
    ->middleware([OnlyMemberMiddleware::class]);

Route::post('/req-letters-update/{id}', [RequestLetterController::class, 'updateReqLetterById'])
    ->name('req-letter.update')
    ->middleware([OnlyMemberMiddleware::class]);

Route::get('/storage/images/profile/{fileName}', function ($fileName) {
    return response()->file(Storage::path("public/images/profile/" . $fileName));
});

Route::get('/storage/images/news/{fileName}', function ($fileName) {
    return response()->file(Storage::path("public/images/news/" . $fileName));
});

Route::get('/storage/documents/{fileName}', function ($fileName) {
    return response()->file(Storage::path("public/documents/" . $fileName));
});

Route::get('/cetak-surat/{id}', [RequestLetterController::class, 'cetakSurat'])
    ->name('cetak.surat')
    ->middleware([OnlyMemberMiddleware::class]);