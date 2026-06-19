<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\VisaController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\LlmsController;
use App\Helpers\LocaleHelper;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SiteLockController;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;

Route::get('/site-lock', [SiteLockController::class, 'show'])->name('site-lock.show');
Route::post('/site-lock', [SiteLockController::class, 'unlock'])
    ->middleware('throttle:5,1')
    ->name('site-lock.unlock');

Route::get('/', function () {
    $locale = request()->cookie('locale') ?: LocaleHelper::detectFromRequest(request());

    return redirect('/'.$locale)->cookie('locale', $locale, 60 * 24 * 365);
});

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-{locale}.xml', [SitemapController::class, 'locale'])->where('locale', 'en|ar|hr')->name('sitemap.locale');
Route::get('/ai-sitemap.xml', [SitemapController::class, 'ai'])->name('sitemap.ai');
Route::get('/llms.txt', [LlmsController::class, 'index'])->name('llms');

Route::prefix('{locale}')
    ->where(['locale' => 'en|ar|hr'])
    ->middleware(SetLocale::class)
    ->group(function () {

        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/about', [AboutController::class, 'index'])->name('about');

        Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
        Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destinations.show');

        Route::get('/tours', [PackageController::class, 'index'])->name('tours.index');
        Route::get('/tours/{slug}', [PackageController::class, 'show'])->name('tours.show');
        Route::get('/packages', fn (string $locale) => redirect()->route('tours.index', $locale, 301))->name('packages.index');
        Route::get('/packages/{slug}', fn (string $locale, string $slug) => redirect()->route('tours.show', [$locale, $slug], 301))->name('packages.show');

        Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
        Route::get('/activities/{slug}', [ActivityController::class, 'show'])->name('activities.show');

        Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
        Route::get('/hotels/{slug}', [HotelController::class, 'show'])->name('hotels.show');

        Route::get('/transportation', [TransportController::class, 'index'])->name('transport.index');
        Route::get('/transportation/{slug}', [TransportController::class, 'show'])->name('transport.show');

        Route::get('/visa-services', [VisaController::class, 'index'])->name('visa.index');

        Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

        Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');

        Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
        Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

        Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
        Route::get('/careers', [CareerController::class, 'index'])->name('careers.index');

        Route::get('/booking/{type}/{id}', [BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking', [BookingController::class, 'store'])->middleware('throttle:5,1')->name('booking.store');
        Route::get('/booking/confirmation/{bookingNumber}', [BookingController::class, 'confirmation'])
            ->middleware('signed')
            ->name('booking.confirmation');

        Route::get('/search', [SearchController::class, 'index'])->name('search');
    });

Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('newsletter.store');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')
    ->middleware(['auth', AdminMiddleware::class])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('packages', AdminPackageController::class);
        Route::resource('activities', AdminActivityController::class);
        Route::resource('blog', AdminBlogController::class);
        Route::resource('gallery', AdminGalleryController::class);
        Route::resource('testimonials', AdminTestimonialController::class);
        Route::resource('sliders', SliderController::class);

        Route::middleware(SuperAdminMiddleware::class)->group(function () {
            Route::resource('users', UserController::class);
        });

        Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');

        Route::get('inquiries', [AdminInquiryController::class, 'index'])->name('inquiries.index');
        Route::get('inquiries/{inquiry}', [AdminInquiryController::class, 'show'])->name('inquiries.show');
        Route::post('inquiries/{inquiry}/reply', [AdminInquiryController::class, 'reply'])->name('inquiries.reply');
        Route::patch('inquiries/{inquiry}/status', [AdminInquiryController::class, 'updateStatus'])->name('inquiries.updateStatus');

        Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
        Route::get('seo/{seoSetting}/edit', [SeoController::class, 'edit'])->name('seo.edit');
        Route::put('seo/{seoSetting}', [SeoController::class, 'update'])->name('seo.update');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
