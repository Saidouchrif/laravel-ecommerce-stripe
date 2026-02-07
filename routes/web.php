<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\AdminOrderController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/stripe', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');

Route::get('/', [HomeController::class, 'showProductLanding'])->name('home');
Route::get('/produits', [HomeController::class, 'showAllProducts'])->name('produits.all');
Route::get('/produits/{id}', [HomeController::class, 'showProduct'])->name('produits.details');
Route::get('/produits/{id}/commande', [HomeController::class, 'showCommande'])->middleware('auth')->name('produits.commande');
Route::post('/orders', [OrderController::class, 'store'])->middleware('auth')->name('orders.store');
Route::get('/stripe/success', [OrderController::class, 'checkoutSuccess'])->name('stripe.success');
Route::get('/stripe/cancel', [OrderController::class, 'checkoutCancel'])->name('stripe.cancel');

// Admin Routes group
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('categories', CategorieController::class)->names('admin.categories');
    Route::resource('produits', ProduitController::class)->names('produits');
    Route::resource('orders', AdminOrderController::class)->names('admin.orders');
    Route::get('orders/{order}/invoice', [AdminOrderController::class, 'viewInvoice'])->name('admin.orders.invoice');
    Route::post('orders/{order}/send-invoice', [AdminOrderController::class, 'sendInvoice'])->name('admin.orders.send-invoice');
    Route::post('orders/{order}/deliver', [AdminOrderController::class, 'markAsDelivered'])->name('admin.orders.deliver');
});

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
