<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MultipleUploadController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pcr', function () {
    return 'Selamat Datang di Website Kampus PCR!';
});

Route::get('/mahasiswa', function () {
    return 'Halo Mahasiswa';
})->name('mahasiswa.show');

Route::get('/nama/{param1}', function ($param1) {
    return 'Nama saya: ' . $param1;
});

Route::get('/nim/{param1?}', function ($param1 = ' ') {
    return 'NIM saya: ' . $param1;
});

Route::get('/mahasiswa/{param1?}', [MahasiswaController::class, 'show']);

Route::get('/about', function () {
    return view('halaman-about');
});

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Route::post('question/store', [QuestionController::class, 'store'])
    ->name('question.store');

route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

Route::resource('pelanggan', PelangganController::class);

Route::resource('user', UserController::class);

Route::get('/profile/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::post('/pelanggan/{id}/files', [MultipleUploadController::class, 'storeForPelanggan'])->name('pelanggan.files.store');
Route::delete('/pelanggan/files/{id}', [MultipleUploadController::class, 'destroy'])->name('pelanggan.files.destroy');
