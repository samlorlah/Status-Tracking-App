<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\AuthenticationController;

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
    return redirect(route('login'));
});

Auth::routes();

Route::prefix('admin')->group(function() {
    Route::get('login', [AuthenticationController::class, 'login'])->name('admin.login');
    Route::post('login', [AuthenticationController::class, 'loginUser'])->name('admin.login-user');
    Route::group(['middleware' => 'adminauth'], function () {
        Route::get('dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('logout', [AuthenticationController::class, 'logoutUser'])->name('admin.logout-user');
        Route::get('application-status/{id}', [HomeController::class, 'viewApplicationStatus'])->name('admin.viewApplicationStatus');
    });
});

Route::get('products/fetch/{id}', [ProductsController::class, 'fetchProduct']);
Route::group(['middleware' => 'adminauth'], function () {
    Route::get('all-products', [ProductsController::class, 'index'])->name('admin.products.index');
    Route::get('products/create', [ProductsController::class, 'create'])->name('admin.products.create');
    Route::post('products/store', [ProductsController::class, 'store'])->name('admin.products.store');
    Route::post('products/delete/{id}', [ProductsController::class, 'delete'])->name('admin.products.delete');
    Route::get('products/add-status', [ProductsController::class, 'addStatus'])->name('admin.products.addStatus');
    Route::get('products/add-client-status', [ProductsController::class, 'addClientStatus'])->name('admin.products.addClientStatus');
    Route::post('products/store-status', [ProductsController::class, 'storeStatus'])->name('admin.products.storeStatus');
    Route::get('products/fetch-status/{id}', [ProductsController::class, 'fetchProgramStatus'])->name('admin.products.fetchProgramStatus');
    Route::post('products/store-client-status', [ProductsController::class, 'storeClientStatus'])->name('admin.products.storeClientStatus');

    Route::prefix('applications')->group(function() {
        Route::get('active', [HomeController::class, 'activeApplications'])->name('admin.applications.active');
        Route::get('view/{id}', [HomeController::class, 'viewApplications'])->name('admin.applications.view');
        Route::post('change-status/{id}', [HomeController::class, 'changeApplicationStatus'])->name('admin.applications.change-status');
        Route::post('update-payment/{id}', [HomeController::class, 'updateApplicationPayment'])->name('admin.applications.updatePayment');
    });
});

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('/apply', [App\Http\Controllers\HomeController::class, 'apply'])->name('user.apply');
Route::get('/fetch-product/{id}', [App\Http\Controllers\HomeController::class, 'fetchProduct'])->name('user.fetch-product');
Route::post('submit-application', [App\Http\Controllers\HomeController::class, 'submitApplication'])->name('user.submit-application');
Route::get('application-status/{id}', [App\Http\Controllers\HomeController::class, 'viewApplicationStatus'])->name('user.viewApplicationStatus');
