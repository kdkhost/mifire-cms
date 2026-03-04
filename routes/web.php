<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PwaController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// ── Auth Routes ───────────────────────────────────────────

Route::get('/admin/login', [Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [Auth\LoginController::class, 'login']);
Route::post('/admin/logout', [Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/admin/forgot-password', [Auth\ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/admin/forgot-password', [Auth\ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/admin/reset-password/{token}', [Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/admin/reset-password', [Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// ── Admin Routes (auth + admin middleware) ────────────────

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Resources
    Route::resource('pages', Admin\PageController::class);
    Route::post('pages/{page}/toggle', [Admin\PageController::class, 'toggleActive'])->name('pages.toggle');

    Route::resource('categories', Admin\CategoryController::class);
    Route::post('categories/reorder', [Admin\CategoryController::class, 'updateOrder'])->name('categories.reorder');

    Route::resource('products', Admin\ProductController::class);
    Route::post('products/{product}/toggle-featured', [Admin\ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::post('products/{product}/toggle-active', [Admin\ProductController::class, 'toggleActive'])->name('products.toggle-active');

    Route::resource('blog', Admin\BlogPostController::class);
    Route::post('blog/{blog}/toggle-publish', [Admin\BlogPostController::class, 'togglePublish'])->name('blog.toggle-publish');
    Route::get('blog/{blog}/preview', [Admin\BlogPostController::class, 'preview'])->name('blog.preview');

    Route::resource('downloads', Admin\DownloadController::class);
    Route::resource('banners', Admin\BannerController::class);
    Route::post('banners/reorder', [Admin\BannerController::class, 'updateOrder'])->name('banners.reorder');
    Route::resource('brands', Admin\BrandController::class);
    Route::post('brands/reorder', [Admin\BrandController::class, 'updateOrder'])->name('brands.reorder');

    Route::get('contacts', [Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::post('contacts/{contact}/reply', [Admin\ContactController::class, 'reply'])->name('contacts.reply');
    Route::delete('contacts/{contact}', [Admin\ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::get('contacts-export', [Admin\ContactController::class, 'export'])->name('contacts.export');

    Route::get('visits', [Admin\VisitController::class, 'index'])->name('visits.index');
    Route::get('visits/stats', [Admin\VisitController::class, 'stats'])->name('visits.stats');
    Route::get('visits/export', [Admin\VisitController::class, 'export'])->name('visits.export');

    Route::resource('addresses', Admin\AddressController::class);
    Route::get('contact-departments', [Admin\ContactDepartmentController::class, 'index'])->name('contact-departments.index');
    Route::post('contact-departments', [Admin\ContactDepartmentController::class, 'store'])->name('contact-departments.store');
    Route::resource('menus', Admin\MenuController::class);
    Route::post('menus/reorder', [Admin\MenuController::class, 'updateOrder'])->name('menus.reorder');
    Route::resource('social-links', Admin\SocialLinkController::class);

    Route::get('settings', [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [Admin\SettingController::class, 'update'])->name('settings.update');

    Route::resource('email-templates', Admin\EmailTemplateController::class)->only(['index', 'edit', 'update']);
    Route::get('email-templates/{email_template}/preview', [Admin\EmailTemplateController::class, 'preview'])->name('email-templates.preview');

    Route::resource('users', Admin\UserController::class);
    Route::post('users/{user}/change-password', [Admin\UserController::class, 'changePassword'])->name('users.change-password');
});

// ── PWA Routes ────────────────────────────────────────────

Route::get('/manifest.json', [PwaController::class, 'manifest']);
Route::get('/offline', [PwaController::class, 'offline'])->name('offline');
Route::get('/sw.js', [PwaController::class, 'serviceWorker']);

// ── Sitemap ───────────────────────────────────────────────

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// ── Frontend Routes (with visit tracking + maintenance middleware) ──────

Route::middleware(['track.visit', 'maintenance'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/categoria/{slug}', [BlogController::class, 'category'])->name('blog.category');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

    Route::get('/downloads', [DownloadController::class, 'index'])->name('downloads.index');
    Route::get('/downloads/{id}', [DownloadController::class, 'download'])->name('downloads.download');

    Route::get('/contato', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contato', [ContactController::class, 'store'])->name('contact.store');

    Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
    Route::get('/produtos/{categorySlug}', [ProductController::class, 'category'])->name('products.category');
    Route::get('/produtos/{categorySlug}/{slug}', [ProductController::class, 'show'])->name('products.show');

    Route::get('/{slug}', [PageController::class, 'show'])->name('page.show'); // catch-all for CMS pages
});

// ── Utility Routes ────────────────────────────────────────

Route::get('/fix-storage', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return "Link simbólico criado com sucesso!";
    } catch (\Exception $e) {
        return "Erro ao criar link simbólico: " . $e->getMessage();
    }
});

Route::get('/run-migration', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'Database\Seeders\ContentMigrationSeeder']);
        return "Migração do conteúdo antigo criada com sucesso! Você já pode fechar esta página e testar o menu.";
    } catch (\Exception $e) {
        return "Erro ao rodar migração: " . $e->getMessage();
    }
});
