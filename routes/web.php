<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/about', fn () => Inertia::render('About'))->name('about');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::post('products/{id}/restore', [ProductController::class, 'productRestore'])->name('products.productRestore');
    Route::get('products/create',[ProductController::class, 'create'])->name('products.create');
    Route::post('products',[ProductController::class, 'store'])->name('products.store');
    Route::get('products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('products/{id}/edit',[ProductController::class,'edit'])->name('products.edit');
    Route::put('products/{id}',[ProductController::class,'update'])->name('products.update');
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');                                    



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
