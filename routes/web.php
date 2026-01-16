<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========== TRANG NGƯỜI DÙNG ==========
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('index', [PageController::class, 'getIndex'])->name('index');
Route::get('loai-san-pham/{id}', [PageController::class, 'getLoaiSp'])->name('loai-san-pham');
Route::get('chi-tiet-san-pham/{id}', [PageController::class, 'getChitiet'])->name('chi-tiet-san-pham');
Route::get('lien-he', [PageController::class, 'getLienhe'])->name('lien-he');
Route::get('gioi-thieu', [PageController::class, 'getGioithieu'])->name('gioi-thieu');

Route::get('add-to-cart/{id}', [PageController::class, 'getAddtoCart'])->name('Themgiohang');
Route::get('del-cart/{id}', [PageController::class, 'getDelItemCart'])->name('xoagiohang');
Route::get('dat-hang', [PageController::class, 'getCheckout'])->name('dathang');
Route::post('dat-hang', [PageController::class, 'postCheckout'])->name('dathang');
Route::get('search', [PageController::class, 'getSearch'])->name('search');

// ========== ĐĂNG NHẬP / ĐĂNG KÝ NGƯỜI DÙNG ==========
Route::get('dangnhap', [PageController::class, 'getLogin'])->name('login');
Route::post('dangnhap', [PageController::class, 'postLogin'])->name('login.submit');
Route::get('dangky', [PageController::class, 'getRegister'])->name('Register');
Route::post('dangky', [PageController::class, 'postRegister'])->name('Register.submit');
Route::post('dang-xuat', [PageController::class, 'postLogout'])->name('logout');

// ======================= ADMIN =======================
Route::prefix('admin')->group(function () {
    // ---------- AUTH ----------
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');

    // BULK ACTION ADMIN
    Route::post('admins/bulk-action', [AdminController::class, 'bulkAction'])
        ->name('admin.bulkAction');
    // ---------- DASHBOARD ----------
    Route::get('/dashboard_5', [AdminController::class, 'dashboard'])->name('admin.dashboard_5');

    // ---------- USERS ADMIN ----------
    Route::prefix('admin')->group(function () {
        Route::get('users', [AdminController::class, 'getAdminUsers'])->name('admin.qly_users_admin.user');
        Route::get('edit/{id}', [AdminController::class, 'editAdmin'])->name('admin.editAdmin');
        Route::post('edit/{id}', [AdminController::class, 'updateAdmin'])->name('admin.updateAdmin');
        Route::get('users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteAdmin');
        Route::post('logout', [AdminController::class, 'logoutAdmin'])->name('admin.logoutAdmin');
    });

    // ---------- USERS NGƯỜI DÙNG ----------
Route::get('users', [AdminController::class, 'getUsers'])->name('admin.users');
Route::get('edit/{id}', [AdminController::class, 'editUser'])->name('admin.user.edit');
Route::post('/edit/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');
Route::get('delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');


    // ---------- PRODUCTS ----------
    Route::get('products', [AdminController::class, 'getProducts'])->name('admin.products');
    Route::get('products/edit/{id}', [AdminController::class, 'editProduct'])->name('admin.product.edit');
    Route::post('products/edit/{id}', [AdminController::class, 'updateProduct'])->name('admin.product.update');
    Route::post('products/create', [AdminController::class, 'createProduct'])->name('admin.product.create');
    Route::get('products/delete/{id}', [AdminController::class, 'deleteProduct'])->name('admin.product.delete');

    // ---------- CART ----------
    Route::middleware(['admin'])->name('admin.')->group(function () {
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('cart/cancel/{id}', [CartController::class, 'canceledOrders'])->name('cart.cancel');
    Route::get('cart/approve', [CartController::class, 'approvedCount'])->name('cart.approve');
});
});

// ========== DANH MỤC (CATEGORIES) ==========
Route::prefix('admin/categories')->name('admin.categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
});

// giỏ hàng khách hàng
Route::post('/order/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');

// thống kê
Route::get('/admin/approved', [CartController::class, 'approvedOrders'])->name('admin.approved');

