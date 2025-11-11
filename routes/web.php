<?php

use App\Http\Controllers\ProfileController;
// admin
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController as ArticleAdminController;
use App\Http\Controllers\Admin\CategoryController as CategoryAdminController;
use App\Http\Controllers\Admin\ContactController as ContactAdminController;
use App\Http\Controllers\Admin\FaqController as FaqAdminController;
use App\Http\Controllers\Admin\QuizController as QuizAdminController;
use App\Http\Controllers\Admin\ReportController as ReportAdminController;
use App\Http\Controllers\Admin\SettingController as SettingAdminController;
use App\Http\Controllers\Admin\TypeController as TypeAdminController;
use App\Http\Controllers\Admin\UserController as UserAdminController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Admin/Home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::group(['prefix' => 'admin', 'middleware' => 'redirectAdmin'], function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/users', [UserAdminController::class, 'index'])->name('admin.user.index');
    Route::patch('/user', [UserAdminController::class, 'update'])->name('admin.user.update');
    Route::delete('/user', [UserAdminController::class, 'destroy'])->name('admin.user.destroy');

    // category
    Route::get('/categories', [CategoryAdminController::class, 'index'])->name('admin.category.index');
    Route::post('/category/create', [CategoryAdminController::class, 'store'])->name('admin.category.create');
    Route::patch('/category/update/{id}', [CategoryAdminController::class, 'update'])->name('admin.category.update');
    Route::delete('/category/delete/{id}', [CategoryAdminController::class, 'destroy'])->name('admin.category.destroy');
    Route::put('/categories/{category}/toggle', [CategoryAdminController::class, 'toggle'])->name('admin.category.toggle');

    // type
    Route::get('/types', [TypeAdminController::class, 'index'])->name('admin.type.index');
    Route::post('/type/create', [TypeAdminController::class, 'store'])->name('admin.type.create');
    Route::patch('/type/update/{id}', [TypeAdminController::class, 'update'])->name('admin.type.update');
    Route::delete('/type/delete/{id}', [TypeAdminController::class, 'destroy'])->name('admin.type.destroy');
    Route::put('/types/{type}/toggle', [TypeAdminController::class, 'toggle'])->name('admin.type.toggle');

    // faq
    Route::get('/faqs', [FaqAdminController::class, 'index'])->name('admin.faq.index');
    Route::post('/faq/create', [FaqAdminController::class, 'store'])->name('admin.faq.create');
    Route::patch('/faq/update/{id}', [FaqAdminController::class, 'update'])->name('admin.faq.update');
    Route::delete('/faq/delete/{id}', [FaqAdminController::class, 'destroy'])->name('admin.faq.destroy');
    Route::put('/faqs/{faq}/toggle', [FaqAdminController::class, 'toggle'])->name('admin.faq.toggle');
    Route::post('/faqs/order', [FaqAdminController::class, 'updateOrder'])->name('faqs.updateOrder');

    // contact
    Route::get('/contacts', [ContactAdminController::class, 'index'])->name('admin.contact.index');
    Route::post('/contact/create', [ContactAdminController::class, 'store'])->name('admin.contact.create');
    Route::patch('/contact/update/{id}', [ContactAdminController::class, 'update'])->name('admin.contact.update');
    Route::delete('/contact/delete/{id}', [ContactAdminController::class, 'destroy'])->name('admin.contact.destroy');
});

require __DIR__.'/auth.php';
