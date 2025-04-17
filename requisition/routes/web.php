<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Needed for Auth::routes()

// Controllers needed for Authentication and Dashboards
use App\Http\Controllers\DashboardRedirectController; // Your redirector
use App\Http\Controllers\HodDashboardController;      // HOD Dashboard
use App\Http\Controllers\FinanceDashboardController; // Finance Dashboard
use App\Http\Controllers\AdminDashboardController;   // Admin/President Dashboard
use App\Http\Controllers\StoreDashboardController;   // Store Manager Dashboard
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserRequisitionController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route::get('/', function () {
//     return redirect()->route('login'); // Often redirect guests to login
// });

Route::get('/about-us', function () {
    // Make sure you have a resources/views/about.blade.php file
    return view('about');
})->name('about.page');


Route::get('/user/dashboard', function () {
    return view('dashboard');
})->name('user.dashboard');; // Use a different name to avoid conflicts if needed

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardRedirectController::class, 'redirect'])->name('dashboard');
    

    // User Type 1 (HOD) - Route name 'hod.dashboard'
    Route::get('/hod/dashboard', [HodDashboardController::class, 'index'])->name('hod.dashboard');

    // User Type 2 (Finance Officer) - Route name 'finance.dashboard'
    Route::get('/finance/dashboard', [FinanceDashboardController::class, 'index'])->name('finance.dashboard');

    // User Type 3 (College President / Admin) - Route name 'admin.dashboard'
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // User Type 4 (Store Manager) - Route name 'store.dashboard'
    Route::get('/store/dashboard', [StoreDashboardController::class, 'index'])->name('store.dashboard');

    // Route::post('/requisitions', [UserRequisitionController::class, 'store'])->name('UserRequisitionController');



});
Route::post('/user/requisitions', [UserRequisitionController::class, 'store'])
     ->middleware('auth') // Example middleware
     ->name('user.requisitions.store'); 
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::resource('requisitions', UserRequisitionController::class)->only([
        'store', // other actions like index, create, show, etc.
    ]);
});
Route::get('/store-dashboard', 'App\Http\Controllers\StoreDashboardController@index');
Route::get('/finance-dashboard', [FinanceDashboardController::class, 'index'])
    ->middleware(['auth', /* add other middleware if needed, e.g., 'is_finance_officer' */])
    ->name('finance.dashboard');
