<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\CategoryController;

Route::redirect('/', '/surat'); // sama seperti redirect ke surat.index

// Arsip Surat (CRUD) + unduh PDF
Route::get('surat/{surat}/download', [SuratController::class, 'download'])
    ->name('surat.download');
Route::resource('surat', SuratController::class)->names('surat');

// Kategori Surat (CRUD)
Route::resource('kategori', CategoryController::class)->names('kategori');

// About
Route::view('/about', 'about')->name('about');
