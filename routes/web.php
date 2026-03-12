<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AccountApprovalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    $stats = [
        ['label' => 'Actieve Makers', 'value' => 8],
        ['label' => 'Openstaande Orders', 'value' => 12],
        ['label' => 'Goedgekeurde Producten', 'value' => 27],
        ['label' => 'Gemiddelde Rating', 'value' => '4.8/5'],
        ['label' => 'Nieuwe Meldingen', 'value' => 3],
        ['label' => 'Credit Transacties', 'value' => 44],
    ];

    return view('dashboard', compact('stats'));
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->middleware('moderator')
        ->name('admin.dashboard');

    // Account approval routes
    Route::get('/admin/accounts/pending', [AccountApprovalController::class, 'index'])
        ->middleware('moderator')
        ->name('admin.accounts.pending');
    Route::post('/admin/accounts/{user}/approve', [AccountApprovalController::class, 'approve'])
        ->middleware('moderator')
        ->name('admin.accounts.approve');
    Route::post('/admin/accounts/{user}/reject', [AccountApprovalController::class, 'reject'])
        ->middleware('moderator')
        ->name('admin.accounts.reject');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])
        ->middleware('maker')
        ->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])
        ->middleware('maker')
        ->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
        ->middleware('maker')
        ->name('products.edit');
    Route::patch('/products/{product}', [ProductController::class, 'update'])
        ->middleware('maker')
        ->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->middleware('maker')
        ->name('products.destroy');

    Route::get('/makers', function () {
        $makers = [
            [
                'name' => 'Sofie De Vries',
                'username' => 'sofie.makes',
                'bio' => 'Keramist met focus op functionele stukken voor dagelijks gebruik.',
            ],
            [
                'name' => 'Milan Jansen',
                'username' => 'milanwoodlab',
                'bio' => 'Houtbewerker die minimalistische keuken- en woonobjecten maakt.',
            ],
            [
                'name' => 'Noor Peeters',
                'username' => 'noorthreads',
                'bio' => 'Textielmaker met liefde voor natuurlijke vezels en kleurcombinaties.',
            ],
        ];

        return view('makers.index', compact('makers'));
    })->name('makers.index');

    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])
        ->middleware('buyer')
        ->name('orders.store');

    // Review routes
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::patch('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    // Statistics routes (moderator/admin only)
    Route::get('/statistics', [StatisticsController::class, 'index'])
        ->middleware('moderator')
        ->name('statistics.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';