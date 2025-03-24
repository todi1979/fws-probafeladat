<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsvImportController;
use App\Http\Controllers\ProductFeedController;

Route::get('/', function () {
    return view('home');
});

Route::post('/import', [CsvImportController::class, 'import'])->name('csv.import');

Route::get('/product-feed-download', [ProductFeedController::class, 'generateFeedDownload'])->name('product-feed-download');
Route::get('/product-feed-view', [ProductFeedController::class, 'generateFeedView'])->name('product-feed-view');
