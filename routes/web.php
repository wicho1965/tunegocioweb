<?php

use App\Livewire\Store\Catalog;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Dashboard\Products\Index as ProductsIndex;
use App\Livewire\Dashboard\Products\Form as ProductForm;
use App\Livewire\Dashboard\Categories\Index as CategoriesIndex;
use App\Livewire\Dashboard\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('home');

require __DIR__.'/auth.php';

// Logout compatible con Breeze + Volt
Route::get('/locale/{lang}', function ($lang) {
    if (! in_array($lang, ['es', 'en'])) {
        abort(400);
    }
    session(['locale' => $lang]);
    return redirect()->back();
})->name('locale.switch');

Route::post('/logout', function () {
    Auth::guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/products', ProductsIndex::class)->name('products.index');
        Route::get('/products/create', ProductForm::class)->name('products.create');
        Route::get('/products/{product}/edit', ProductForm::class)->name('products.edit');
        Route::get('/categories', CategoriesIndex::class)->name('categories.index');
        Route::get('/settings', Settings::class)->name('settings');
    });
});

// Catálogo público (siempre al final)
Route::get('/{store:slug}', Catalog::class)->name('store.catalog');
