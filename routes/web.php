<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'showProductLanding'])->name('home');
Route::get('/produits', [HomeController::class, 'showAllProducts'])->name('produits.all');
Route::get('/produits/{id}', [HomeController::class, 'showProduct'])->name('produits.details');
Route::get('/produits/{id}/commande', [HomeController::class, 'showCommande'])->name('produits.commande');

// Admin Route
Route::get('/admin', [AdminController::class, 'index'])->middleware('auth')->name('admin.dashboard');

// Admin Category Routes
Route::resource('admin/categories', CategorieController::class)->middleware('auth')->names([
    'index' => 'admin.categories.index',
    'create' => 'admin.categories.create',
    'store' => 'admin.categories.store',
    'edit' => 'admin.categories.edit',
    'update' => 'admin.categories.update',
    'destroy' => 'admin.categories.destroy',
]);

// Product Routes
Route::resource('admin/produits', ProduitController::class)->middleware('auth')->names([
    'index' => 'produits.index',
    'create' => 'produits.create',
    'store' => 'produits.store',
    'show' => 'produits.show',
    'edit' => 'produits.edit',
    'update' => 'produits.update',
    'destroy' => 'produits.destroy',
]);

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Password Reset Routes
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});

Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/db-test', function () {
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        return "Database connection is working!";
    } catch (\Exception $e) {
        return "Database error: " . $e->getMessage();
    }
});

// Route de changement de langue
Route::get('/lang/{locale}', function ($locale) {
    // Vérifier que la locale est valide
    if (!in_array($locale, ['fr', 'ar'])) {
        abort(404);
    }

    // Stocker la locale en session
    session(['locale' => $locale]);

    // Rediriger vers la page d'accueil pour éviter les incohérences
    return redirect()->route('home');
})->name('lang.switch');
