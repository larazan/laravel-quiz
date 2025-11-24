<?php

// admin
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController as ArticleAdminController;
use App\Http\Controllers\Admin\CategoryController as CategoryAdminController;
use App\Http\Controllers\Admin\CategoryArticleController;
use App\Http\Controllers\Admin\ContactController as ContactAdminController;
use App\Http\Controllers\Admin\FaqController as FaqAdminController;
use App\Http\Controllers\Admin\QuizController as QuizAdminController;
use App\Http\Controllers\Admin\QuestionController as QuestionAdminController;
use App\Http\Controllers\Admin\ReportController as ReportAdminController;
use App\Http\Controllers\Admin\SettingController as SettingAdminController;
use App\Http\Controllers\Admin\TypeController as TypeAdminController;
use App\Http\Controllers\Admin\UserController as UserAdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;

// frontend
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SettingController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/quizzes', [QuizController::class,'index'])->name('quizzes');
Route::get('quizzes/{slug}', [QuizController::class, 'show'])->name('quizzes.show');

Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs.index');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('user/{username?}', [ProfileController::class, 'show'])->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('/setting', [SettingController::class, 'edit'])->name('setting.edit');
    Route::patch('/setting', [SettingController::class, 'update'])->name('setting.update');
    Route::delete('/setting', [SettingController::class, 'destroy'])->name('setting.destroy');
});

Route::group(['prefix' => 'admin', 'middleware' => 'redirectAdmin'], function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // user
    Route::get('/users', [UserAdminController::class, 'index'])->name('admin.user.index');
    Route::patch('/user', [UserAdminController::class, 'update'])->name('admin.user.update');
    Route::delete('/user', [UserAdminController::class, 'destroy'])->name('admin.user.destroy');
    Route::post('/users/{user}/sync-roles', [UserAdminController::class, 'syncRoles']);
    Route::post('/users/{user}/sync-permissions', [UserAdminController::class, 'syncPermissions']);
    

    // article
    Route::get('/articles', [ArticleAdminController::class, 'index'])->name('admin.article.index');
    Route::post('/article/create', [ArticleAdminController::class, 'store'])->name('admin.article.create');
    Route::patch('/article/update/{id}', [ArticleAdminController::class, 'update'])->name('admin.article.update');
    Route::delete('/article/delete/{id}', [ArticleAdminController::class, 'destroy'])->name('admin.article.destroy');
    Route::put('/articles/{article}/toggle', [ArticleAdminController::class, 'toggleActive'])->name('admin.article.toggle');
    Route::put('/articles/{article}/publish', [ArticleAdminController::class, 'togglePublish'])->name('admin.article.publish');

    // category
    Route::get('/categories', [CategoryAdminController::class, 'index'])->name('admin.category.index');
    Route::post('/category/create', [CategoryAdminController::class, 'store'])->name('admin.category.create');
    Route::patch('/category/update/{id}', [CategoryAdminController::class, 'update'])->name('admin.category.update');
    Route::delete('/category/delete/{id}', [CategoryAdminController::class, 'destroy'])->name('admin.category.destroy');
    Route::put('/categories/{category}/toggle', [CategoryAdminController::class, 'toggle'])->name('admin.category.toggle');

    // category article
    Route::get('/category-articles', [CategoryArticleController::class, 'index'])->name('admin.category-article.index');
    Route::post('/category-article/create', [CategoryArticleController::class, 'store'])->name('admin.category-article.create');
    Route::patch('/category-article/update/{id}', [CategoryArticleController::class, 'update'])->name('admin.category-article.update');
    Route::delete('/category-article/delete/{id}', [CategoryArticleController::class, 'destroy'])->name('admin.category-article.destroy');

    // type
    Route::get('/types', [TypeAdminController::class, 'index'])->name('admin.type.index');
    Route::post('/type/create', [TypeAdminController::class, 'store'])->name('admin.type.create');
    Route::patch('/type/update/{id}', [TypeAdminController::class, 'update'])->name('admin.type.update');
    Route::delete('/type/delete/{id}', [TypeAdminController::class, 'destroy'])->name('admin.type.destroy');
    Route::put('/types/{type}/toggle', [TypeAdminController::class, 'toggle'])->name('admin.type.toggle');

    // quiz
    Route::get('/quizzes', [QuizAdminController::class, 'index'])->name('admin.quiz.index');
    Route::post('/quiz/create', [QuizAdminController::class, 'store'])->name('admin.quiz.create');
    Route::patch('/quiz/update/{id}', [QuizAdminController::class, 'update'])->name('admin.quiz.update');
    Route::delete('/quiz/delete/{id}', [QuizAdminController::class, 'destroy'])->name('admin.quiz.destroy');
    Route::put('/quizzes/{quiz}/approve', [QuizAdminController::class, 'toggleApprove'])->name('admin.quiz.approve');
    Route::put('/quizzes/{quiz}/publish', [QuizAdminController::class, 'togglePublish'])->name('admin.quiz.publish');
    Route::put('/quizzes/{quiz}/private', [QuizAdminController::class, 'togglePrivate'])->name('admin.quiz.private');

     // question
     Route::get('/questions', [QuestionAdminController::class, 'index'])->name('admin.question.index');
     Route::post('/question/create', [QuestionAdminController::class, 'store'])->name('admin.question.create');
     Route::patch('/question/update/{id}', [QuestionAdminController::class, 'update'])->name('admin.question.update');
     Route::delete('/question/delete/{id}', [QuestionAdminController::class, 'destroy'])->name('admin.question.destroy');
     Route::put('/questions/{question}/active', [QuestionAdminController::class, 'toggleActive'])->name('admin.question.active');
     Route::put('/questions/{question}/private', [QuestionAdminController::class, 'togglePrivate'])->name('admin.question.private');

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

    // setting
    Route::get('/settings', [SettingAdminController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingAdminController::class, 'update'])->name('settings.update');

    // role & permission
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});

require __DIR__.'/auth.php';
