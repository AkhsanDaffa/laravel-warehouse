<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Halaman Utama (Dashboard)
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Aksi-aksi (Simpan, Update Stok, Hapus)
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::post('/products/{id}/stock', [ProductController::class, 'updateStock'])->name('products.stock');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');