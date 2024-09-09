<?php

use App\Http\Controllers\Admin\AuthorController as AdminAuthorController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::middleware('role:user')->group(function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/books', [UserController::class, 'index'])->name('user.books.index');
            Route::get('/books/borrowed', [UserController::class, 'borrowBooks'])->name('user.books.borrowed');
            Route::get('/{author}/books', [UserController::class, 'author'])->name('user.books.by-author');
            Route::post('/{book}/borrow', [UserController::class, 'borrow'])->name('user.books.borrow');
            Route::patch('/{book}/return', [UserController::class, 'return'])->name('user.books.return');
        });
    });

    Route::middleware('role:admin')->group(function () {
        Route::group(['prefix' => 'admin'], function () {
            Route::group(['prefix' => 'authors'], function () {
                Route::get('/', [AdminAuthorController::class, 'index'])->name('admin.authors.index');
                Route::get('/create', [AdminAuthorController::class, 'create'])->name('admin.authors.create');
                Route::post('/', [AdminAuthorController::class, 'store'])->name('admin.authors.store');
                Route::get('/{author}', [AdminAuthorController::class, 'show'])->name('admin.authors.show');
                Route::put('/{author}', [AdminAuthorController::class, 'update'])->name('admin.authors.update');
                Route::delete('/{author}', [AdminAuthorController::class, 'delete'])->name('admin.authors.delete');
            });

            Route::group(['prefix' => 'books'], function () {
                Route::get('/', [AdminBookController::class, 'index'])->name('admin.books.index');
                Route::get('/create', [AdminBookController::class, 'create'])->name('admin.books.create');
                Route::post('/', [AdminBookController::class, 'store'])->name('admin.books.store');
                Route::get('/{book}', [AdminBookController::class, 'show'])->name('admin.books.show');
                Route::put('/{book}', [AdminBookController::class, 'update'])->name('admin.books.update');
                Route::delete('/{book}', [AdminBookController::class, 'delete'])->name('admin.books.delete');
            });
        });
    });

});

require __DIR__.'/auth.php';
