<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FileController;
use App\Http\Controllers\JournalController;

Route::get('/', [FileController::class, 'uploadPage'])->name('upload.page');
Route::post('/upload', [FileController::class, 'upload'])->name('upload.process');

Route::get('/parse/{id}', [FileController::class, 'parse'])->name('parse');
Route::post('/save-classified/{id}', [FileController::class, 'save'])->name('save.classified');

Route::get('/dashboard', [FileController::class, 'dashboard'])->name('dashboard');

Route::get('/export-excel', [FileController::class, 'exportExcel'])->name('export.excel');
Route::get('/export-pdf', [FileController::class, 'exportPdf'])->name('export.pdf');

// ===============================
//  Halaman Upload Journal Report
// ===============================
Route::get(
    '/journal/upload',
    [JournalController::class, 'uploadPage']
)->name('journal.upload');

Route::post(
    '/journal/upload',
    [JournalController::class, 'uploadProcess']
)->name('journal.upload.process');


// ===============================
//  Dashboard Klasifikasi
// ===============================
Route::get(
    '/journal/dashboard',
    [JournalController::class, 'dashboard']
)->name('journal.dashboard');


// ===============================
//  Detail per kategori (optional)
// ===============================
Route::get(
    '/journal/category/{category}',
    [JournalController::class, 'categoryDetail']
)->name('journal.category');
