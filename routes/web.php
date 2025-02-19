<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //permission route
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('permissions/{id}', [PermissionController::class,'deletee'])->name('delete.artical');
    Route::get('articaledit/{id}', [PermissionController::class,'articaledit']);
    Route::put('edit-artical/{id}', [PermissionController::class,'update']);

    //roles route
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{id}/edit', [RoleController::class,'edit'])->name('roles.edit');
    Route::post('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::get('roles/{id}', [RoleController::class,'delete'])->name('delete.roles');

    //articles route

    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('articels/{id}', [ArticleController::class,'deletea'])->name('deletea.artical');
    Route::get('articelsedit/{id}', [ArticleController::class,'articelsedit']);
    Route::put('edit-articels/{id}', [ArticleController::class,'Aupdate']);

    // Route::get('roles/{id}/edit', [RoleController::class,'edit'])->name('roles.edit');
    // Route::post('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    // Route::get('roles/{id}', [RoleController::class,'delete'])->name('delete.roles');

    //users route

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
     Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
     Route::post('/users', [UserController::class, 'store'])->name('users.store');
     Route::get('users/{id}/edit', [UserController::class,'edit'])->name('users.edit');
     Route::post('/users/{id}', [UserController::class, 'update'])->name('users.update');
     Route::delete('/users/{id}', [UserController::class,'destroy'])->name('delete.users');

});

require __DIR__.'/auth.php';
