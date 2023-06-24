<?php

use App\Http\Controllers\BillingManagement\BillingManagement;
use App\Http\Controllers\CatalogueManagement\StockUnitController;
use App\Http\Controllers\ProductManagement\ProductManagement;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockManagement\StockController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagement\UserController;
use App\Http\Controllers\UserManagement\RoleController;
use App\Models\BillingManagment\BillingManagment;

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

// Route::get('/', function () {
//     return view('auth.login');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('auth.login');
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Settings
    Route::view('settings/change-password', 'user_management.profile.change_password')->name('users.edit.password');
    Route::post('settings/change-password', [ProfileController::class, 'updatePassword'])->name('users.update.password');

    /* ********************************** */
    // User Management
    /* ********************************** */
    // Manage Users
    Route::resource('user-management/users', UserController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
    Route::post('user-management/users/get', [UserController::class, 'get'])->name('users.get');
    Route::post('user-management/users/{id}/get-user-roles', [UserController::class, 'getRoles'])->name('users.get.roles');
    Route::post('user-management/users/{id}/get-user-permissions', [UserController::class, 'getPermissions'])->name('users.get.permissions');
    Route::post('user-management/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('user-management/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('user-management/users/{id}/roles', [UserController::class, 'updateRoles'])->name('users.update.roles');
    Route::put('user-management/users/{id}/permissions', [UserController::class, 'updatePermissions'])->name('users.update.permissions');

    // Manage Roles
    Route::resource('user-management/roles', RoleController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
    Route::post('user-management/roles/get', [RoleController::class, 'get'])->name('roles.get');
    Route::post('user-management/roles/{id}/get-role-permissions', [RoleController::class, 'getPermissions'])->name('roles.get.permissions');
    Route::post('user-management/roles/{id}', [RoleController::class, 'show'])->name('roles.show');
    Route::post('user-management/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('user-management/roles/{id}/roles', [RoleController::class, 'updateRoles'])->name('roles.update.roles');
    Route::put('user-management/roles/{id}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.update.permissions');

    // Manage Stock Unit
    Route::resource('catalogue-management/stock-unit', StockUnitController::class)->only([
        'index', 'store', 'update', 'destroy'
    ])->names([
        'index' => 'stock_unit.index',
        'store' => 'stock_unit.store',
        'update' => 'stock_unit.update',
        'destroy' => 'stock_unit.destroy',
    ]);
    Route::post('catalogue-management/stock-unit/get', [StockUnitController::class, 'get'])->name('stock_unit.get');
    Route::post('catalogue-management/stock-unit/{id}', [StockUnitController::class, 'show'])->name('stock_unit.show');
    Route::post('catalogue-management/stock-unit/{id}/edit', [StockUnitController::class, 'edit'])->name('stock_unit.edit');

    /* ********************************** */
    // Stock Management
    /* ********************************** */
    // Manage Stock
    Route::resource('stock-management/stock', StockController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
    Route::post('stock-management/stock/get', [StockController::class, 'get'])->name('stock.get');
    Route::post('stock-management/stock/{id}', [StockController::class, 'show'])->name('stock.show');
    Route::post('stock-management/stock/{id}/edit', [StockController::class, 'edit'])->name('stock.edit');
});


Route::resource('product-management/product', ProductManagement::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('product-management/product/add_more_ingredients/{count?}', [ProductManagement::class, 'add_more_ingredients'])->name('add_more_ingredients');
Route::post('product-management/product/get', [ProductManagement::class, 'get'])->name('product.get');
Route::post('product-management/product/{id}', [ProductManagement::class, 'show'])->name('product.show');
Route::post('product-management/product/{id}/edit', [ProductManagement::class, 'edit'])->name('product.edit');
Route::get('product-management/product/{id}/delete_ingredient', [ProductManagement::class, 'delete_ingredient'])->name('product.delete_ingredient');
Route::get('product-management/product/{id}/delete_img', [ProductManagement::class, 'delete_img'])->name('product.delete_img');

Route::resource('billing-management/billing', BillingManagement::class)->only([
    'index', 'store', 'update', 'destroy'
]);

require __DIR__.'/auth.php';
