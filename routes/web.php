<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JournalCreditFacilityController;
use App\Http\Controllers\JournalMarketExecutionController;
use App\Http\Controllers\JournalWrongPriceController;
use App\Http\Controllers\EquityReportController;
use App\Http\Controllers\JournalIPPerusahaanController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/auth/google', [AuthController::class, 'login_with_google']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


Route::middleware('auth', 'user-aktif')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/upload/page', [FileController::class, 'uploadPage'])->name('upload.page');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/upload', [FileController::class, 'upload'])->name('upload.process');
    Route::get('/parse/{id}', [FileController::class, 'parse'])->name('parse');
    Route::post('/save-classified/{id}', [FileController::class, 'save'])->name('save.classified');
    // Route::get('/dashboard', [FileController::class, 'dashboard'])->name('dashboard');
    Route::get('/export-excel', [FileController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export-pdf', [FileController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/journal/upload', [JournalController::class, 'uploadPage'])->name('journal.upload');
    Route::post('/journal/upload', [JournalController::class, 'uploadProcessJournal'])->name('journal.upload.process');
    Route::post('/journal/compare', [JournalController::class, 'uploadProcessJournalHistoryStatement'])->name('journal.upload.compare');
    Route::post('/journal/upload/multi', [JournalController::class, 'uploadMultiJournal'])->name('journal.upload.multi');
    Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
    Route::get('/journal/category/{category}', [JournalController::class, 'categoryDetail'])->name('journal.category');
    Route::get('/journal/export-pdf', [JournalController::class, 'exportPDF'])->name('journal.pdf');
    Route::post('/journal/save/ip-perusahaan', [JournalController::class, 'saveIPPerusahaan'])->name('journal.save.ip-perusahaan');
    Route::post('/journal/save/all', [JournalController::class, 'saveAll'])->name('journal.save.all');
    Route::post('/journal/save/ip-publik', [JournalController::class, 'saveIPPublik'])->name('journal.save.ip-publik');
    Route::post('/journal/save/market', [JournalController::class, 'saveMarket'])->name('journal.save.market');
    Route::post('/journal/save/wrong', [JournalController::class, 'saveWrong'])->name('journal.save.wrong');
    Route::post('/journal/save/credit', [JournalController::class, 'saveCredit'])->name('journal.save.credit');
    Route::get('/equity/upload', [EquityReportController::class, 'upload'])->name('equity.upload');
    Route::post('/equity/upload', [EquityReportController::class, 'uploadProcessEquity'])->name('equity.upload.process');
    Route::post('/equity/save/compare', [EquityReportController::class, 'saveComparison'])->name('equity.save.compare');
    Route::resource('/journal/ip-perusahaan', JournalIPPerusahaanController::class);
    Route::resource('/journal/market-execution', JournalMarketExecutionController::class);
    Route::resource('/journal/wrong-price', JournalWrongPriceController::class);
    Route::resource('/journal/credit-facility', JournalCreditFacilityController::class);
    Route::resource('/equity', EquityReportController::class);
});
