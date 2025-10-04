<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ProfileController;
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
    return view('app');
});


// Guest only routes (redirect to home if already logged in)
Route::middleware(['guest'])->group(function () {
    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Logout (authenticated users only)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');



// Public routes - can be accessed without authentication
Route::get('/campaigns', [DonationController::class, 'index'])->name('donations.index');
Route::get('/campaigns/{id}', [DonationController::class, 'show'])->name('donations.show');

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    // Profile
    // Show profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    // Edit profile form
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // Update profile
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Update password
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // Delete account
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Create donation
    Route::get('/campaigns/{campaignId}/donate', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');

    // Payment routes
    Route::get('/donations/{donationId}/payment', [DonationController::class, 'payment'])->name('donations.payment');
    Route::post('/donations/{donationId}/process-payment', [DonationController::class, 'processPayment'])->name('donations.process-payment');

    // Success page
    Route::get('/donations/{donationId}/success', [DonationController::class, 'success'])->name('donations.success');

    // User donation history
    Route::get('/my-donations', [DonationController::class, 'myDonations'])->name('donations.my-donations');

    // Download receipt
    Route::get('/donations/{donationId}/receipt', [DonationController::class, 'downloadReceipt'])->name('donations.receipt');
});
