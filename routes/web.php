<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\Admin\EmailTemplatesController;
use App\Http\Controllers\Admin\FaqsController;
use App\Http\Controllers\Admin\GatewaysController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Controllers\Admin\PayoutsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PagesViewController;
use App\Http\Controllers\Front\SitemapController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\EarningsController;
use App\Http\Controllers\User\FundsController;
use App\Http\Controllers\User\UserSettingsController;
use App\Http\Controllers\User\VideoController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/paginate', [HomeController::class, 'paginate']);
Route::get('/video/{video_id}/{slug}', [HomeController::class, 'video'])->name('video');
Route::post('/earning/{id}', [HomeController::class, 'earning'])->name('earning');

//Search
Route::get('/search', [HomeController::class, 'search'])->name('search');

//Pages
Route::get('/about', [PagesViewController::class, 'about'])->name('about');
Route::get('/privacy-policy', [PagesViewController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [PagesViewController::class, 'terms'])->name('terms');
Route::get('/cookie-policy', [PagesViewController::class, 'cookie'])->name('cookie');
Route::get('/faqs', [PagesViewController::class, 'faqs'])->name('faqs');

//Users
Route::get('/users', [HomeController::class, 'users'])->name('users');
Route::get('/users/sort', [HomeController::class, 'sortUsers'])->name('users.sort');
Route::get('/users/pagination', [HomeController::class, 'sortUsers']);
Route::get('/profile/{id}/{slug}', [HomeController::class, 'user'])->name('user');
Route::get('/profile/{id}/{slug}/paginate', [HomeController::class, 'user_paginate'])->name('user_paginate');

//Leaderboard
Route::get('/leaderboard', [HomeController::class, 'leaderboard'])->name('leaderboard');
Route::get('/leaderboard/sort', [HomeController::class, 'sortLeaderboard'])->name('leaderboard.sort');
Route::get('/leaderboard/pagination', [HomeController::class, 'sortLeaderboard']);

//Categories
Route::get('/categories', [HomeController::class, 'categories'])->name('categories');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category');
Route::get('/category/{slug}/paginate', [HomeController::class, 'category_paginate'])->name('category_paginate');

Route::get('/add', [HomeController::class, 'add'])->name('add');
Route::get('/language/{locale}', [LanguageController::class, 'changeLanguage'])->name('language.change');

//Auth
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('auth.register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/login', [LoginController::class, 'create'])->middleware('guest')->name('auth.login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('/forgot-password' ,[ForgotPasswordController::class, 'forgot'])->middleware('guest')->name('auth.forgot');
Route::post('/forgot-password' ,[ForgotPasswordController::class, 'forgotPassword']);
Route::get('/reset-password/{email}/{token}' ,[ForgotPasswordController::class, 'resetPassword'])->middleware('guest')->name('reset');
Route::post('/reset-password' ,[ForgotPasswordController::class, 'updatePassword'])->name('update.password');

//Email Verification
Route::controller(VerificationController::class)->group(function() {
    Route::get('/email/verify', 'notice')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', 'verify')->name('verification.verify');
    Route::post('/email/resend', 'resend')->name('verification.resend');
});

// Social Login redirect and callback urls
Route::get('/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/facebook', [FacebookController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

//Trumbowyg Image Upload
Route::post('/trumb/upload', [HomeController::class, 'upload'])->name('trumb.upload');

//Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemap_categories.xml', [SitemapController::class, 'categories'])->name('sitemap.categories');
Route::get('/sitemap_pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('/sitemap_videos.xml', [SitemapController::class, 'videos'])->name('sitemap.videos');
Route::get('/sitemap_users.xml', [SitemapController::class, 'users'])->name('sitemap.users');

//Robots
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

/*------------------------------------------
--------------------------------------------
User Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['prefix' =>'user', 'middleware' => ['auth', 'user']], function(){

	//Overview
    Route::get('/payments', [DashboardController::class, 'payments'])->name('user.payments');
    Route::get('/viewers', [DashboardController::class, 'viewers'])->name('user.viewers');
    Route::post('/mark-as-read', [DashboardController::class, 'mark_as_read']);

	//Videos
    Route::get('/videos/list', [VideoController::class, 'list'])->name('user.videos.list');
    Route::get('/videos/pagination', [VideoController::class, 'paginate']);
    Route::get('/videos/add', [VideoController::class, 'add'])->name('user.videos.add');
    Route::post('/videos/add', [VideoController::class, 'store']);
    Route::get('/videos/edit/{id}', [VideoController::class, 'edit'])->name('user.videos.edit');
    Route::post('/videos/edit/{id}', [VideoController::class, 'update']);
    Route::get('/videos/topup/{id}', [VideoController::class, 'topup'])->name('user.videos.topup');
    Route::post('/videos/topup/{id}', [VideoController::class, 'topup_post']);
	Route::post('/videos/destroy', [VideoController::class, 'destroy'])->name('user.videos.destroy');
    Route::get('/videos/view/{id}', [VideoController::class, 'view'])->name('user.videos.view');


	//Profile Settings
    Route::get('/profile', [UserSettingsController::class, 'profile'])->name('user.profile');
    Route::post('/profile', [UserSettingsController::class, 'update']);
    Route::get('/password', [UserSettingsController::class, 'password'])->name('user.password');
    Route::post('/password', [UserSettingsController::class, 'password_update']);
    Route::get('/email/notifications', [UserSettingsController::class, 'email_notifications'])->name('user.email.notifications');
    Route::post('/email/notifications', [UserSettingsController::class, 'email_notifications_update']);

    //Wallet
    Route::get('/wallet', [FundsController::class, 'index'])->name('user.wallet');
	Route::get('/wallet/invoice/{id}',[FundsController::class, 'invoice'] )->name('user.wallet.invoice');
    Route::get('/funds/add', [FundsController::class, 'add_funds'])->name('user.funds.add');
    Route::post('/funds/add', [FundsController::class, 'add_funds']);
    Route::get('/paypal/success', [FundsController::class, 'paypal_success'])->name('paypal.success');
    Route::get('/stripe/success', [FundsController::class, 'stripe_success'])->name('stripe.success');
    Route::get('/stripe/cancel', [FundsController::class, 'stripe_cancel'])->name('stripe.cancel');
    Route::post('razorpay/payment', [FundsController::class, 'razorpay_payment'])->name('razorpay.payment');
    Route::get('paystack/payment/{reference}', [FundsController::class, 'paystack_payment'])->name('paystack.payment');
    Route::post('mollie/post', [FundsController::class, 'mollie_post'])->name('mollie.post');
    Route::get('mollie/success', [FundsController::class, 'mollie_success'])->name('mollie.success');
    Route::get('mollie/cancel', [FundsController::class, 'mollie_cancel'])->name('mollie.cancel');
    Route::post('flutterwave/post', [FundsController::class, 'flutterwave_post'])->name('flutterwave.post');
	Route::get('flutterwave/callback', [FundsController::class, 'flutterwave_callback'])->name('flutterwave.callback');
    Route::post('bank/post', [FundsController::class, 'bank_post'])->name('bank.post');

    //Withdrawals
    Route::get('/earnings', [EarningsController::class, 'earnings'])->name('user.earnings');
    Route::get('/withdrawals', [EarningsController::class, 'withdrawals'])->name('user.withdrawals');
    Route::post('/withdrawals/set', [EarningsController::class, 'set'])->name('user.withdrawals.set');
    Route::post('/withdraw', [EarningsController::class, 'withdraw'])->name('user.withdraw');

});
Route::group(['prefix' =>'admin', 'middleware' => ['auth', 'admin']], function(){

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

	//Admin Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/profile', [AdminController::class, 'update']);

	//Users Settings
    Route::get('/users/list', [UserController::class, 'index'])->name('admin.users.list');
    Route::post('/users/add', [UserController::class, 'store'])->name('admin.users.add');
    Route::get('/users/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/users/update', [UserController::class, 'update'])->name('admin.users.update');
	Route::post('/users/destroy', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/users/view/{id}', [UserController::class, 'view'])->name('admin.users.view');
    Route::get('/users/funds/{id}', [UserController::class, 'funds'])->name('admin.users.funds');
    Route::post('/users/update_funds', [UserController::class, 'update_funds'])->name('admin.users.update_funds');

	//Languages Settings
    Route::get('/languages/list', [LanguageController::class, 'index'])->name('admin.languages.index');
    Route::post('/languages/add', [LanguageController::class, 'postAdd'])->name('admin.languages.add');
    Route::get('/languages/{language}/phrases', [LanguageController::class, 'edit'])->name('admin.languages.edit');
    Route::post('/languages/update-phrase', [LanguageController::class, 'update'])->name('admin.languages.update');
    Route::get('/languages/default', [LanguageController::class, 'default'])->name('admin.languages.default');
    Route::post('/languages/default', [LanguageController::class, 'postDefault']);
    Route::post('/languages/delete', [LanguageController::class,'delete'])->name('admin.languages.delete');
    Route::get('/languages/dates', [LanguageController::class, 'dates'])->name('admin.languages.dates');
    Route::post('/languages/dates', [LanguageController::class, 'postDates']);

	//Site Settings
    Route::get('/settings/site', [SettingsController::class, 'index'])->name('admin.settings.site');
    Route::post('/settings/site', [SettingsController::class, 'update']);
    Route::get('/settings/video', [SettingsController::class, 'video'])->name('admin.settings.video');
    Route::post('/settings/video', [SettingsController::class, 'video_post']);
    Route::get('/settings/home', [SettingsController::class, 'home'])->name('admin.settings.home');
    Route::post('/settings/home', [SettingsController::class, 'home_post']);
    Route::get('/settings/currency', [SettingsController::class, 'currency'])->name('admin.settings.currency');
    Route::post('/settings/currency', [SettingsController::class, 'currency_post']);
    Route::get('/settings/payments', [SettingsController::class, 'payments'])->name('admin.settings.payments');
    Route::post('/settings/payments', [SettingsController::class, 'payments_post']);
    Route::get('/settings/ads', [SettingsController::class, 'ads'])->name('admin.settings.ads');
    Route::post('/settings/ads', [SettingsController::class, 'ads_post']);
    Route::get('/settings/analytics', [SettingsController::class, 'analytics'])->name('admin.settings.analytics');
    Route::post('/settings/analytics', [SettingsController::class, 'analytics_post']);
    Route::get('/settings/adsense', [SettingsController::class, 'adsense'])->name('admin.settings.adsense');
    Route::post('/settings/adsense', [SettingsController::class, 'adsense_post']);
    Route::get('/settings/social', [SettingsController::class, 'social'])->name('admin.settings.social');
    Route::post('/settings/social', [SettingsController::class, 'social_post']);

    //Payment Gateways Settings
    Route::get('/gateways/paypal', [GatewaysController::class, 'paypal'])->name('admin.gateways.paypal');
    Route::post('/gateways/paypal', [GatewaysController::class, 'paypal_post']);
    Route::get('/gateways/stripe', [GatewaysController::class, 'stripe'])->name('admin.gateways.stripe');
    Route::post('/gateways/stripe', [GatewaysController::class, 'stripe_post']);
    Route::get('/gateways/razorpay', [GatewaysController::class, 'razorpay'])->name('admin.gateways.razorpay');
    Route::post('/gateways/razorpay', [GatewaysController::class, 'razorpay_post']);
    Route::get('/gateways/paystack', [GatewaysController::class, 'paystack'])->name('admin.gateways.paystack');
    Route::post('/gateways/paystack', [GatewaysController::class, 'paystack_post']);
    Route::get('/gateways/mollie', [GatewaysController::class, 'mollie'])->name('admin.gateways.mollie');
    Route::post('/gateways/mollie', [GatewaysController::class, 'mollie_post']);
    Route::get('/gateways/flutterwave', [GatewaysController::class, 'flutterwave'])->name('admin.gateways.flutterwave');
    Route::post('/gateways/flutterwave', [GatewaysController::class, 'flutterwave_post']);
    Route::get('/gateways/bank', [GatewaysController::class, 'bank'])->name('admin.gateways.bank');
    Route::post('/gateways/bank', [GatewaysController::class, 'bank_post']);

    //Auth Settings
    Route::get('/auth/google', [AuthController::class, 'google'])->name('admin.auth.google');
    Route::post('/auth/google', [AuthController::class, 'google_post']);
    Route::get('/auth/facebook', [AuthController::class, 'facebook'])->name('admin.auth.facebook');
    Route::post('/auth/facebook', [AuthController::class, 'facebook_post']);
    Route::get('/auth/email', [AuthController::class, 'email'])->name('admin.auth.email');
    Route::post('/auth/email', [AuthController::class, 'email_post']);
    Route::get('/auth/recaptcha', [AuthController::class, 'recaptcha'])->name('admin.auth.recaptcha');
    Route::post('/auth/recaptcha', [AuthController::class, 'recaptcha_post']);

    //Email Settings
    Route::get('/settings/mail', [EmailController::class, 'index'])->name('admin.settings.mail');
	Route::post('/settings/mail', [EmailController::class, 'update']);

	//Email Templates
    Route::get('/email/list', [EmailTemplatesController::class, 'index'])->name('admin.email.list');
    Route::get('/email/add', [EmailTemplatesController::class, 'index'])->name('admin.email.add');
    Route::post('/email/add', [EmailTemplatesController::class, 'store']);
    Route::get('/email/edit/{id}', [EmailTemplatesController::class, 'edit'])->name('admin.email.edit');
    Route::post('/email/update', [EmailTemplatesController::class, 'update'])->name('admin.email.update');
    Route::get('/email/view', [EmailTemplatesController::class, 'view'])->name('admin.email.view');
	Route::post('/email/destroy', [EmailTemplatesController::class, 'destroy'])->name('admin.email.destroy');

	//Pages Settings
    Route::get('/pages/list', [PagesController::class, 'index'])->name('admin.pages.list');
    Route::get('/pages/add', [PagesController::class, 'index'])->name('admin.pages.add');
    Route::post('/pages/add', [PagesController::class, 'store']);
    Route::get('/pages/edit/{id}', [PagesController::class, 'edit'])->name('admin.pages.edit');
    Route::post('/pages/update', [PagesController::class, 'update'])->name('admin.pages.update');
    Route::get('/pages/view', [PagesController::class, 'view'])->name('admin.pages.view');
	Route::post('/pages/destroy', [PagesController::class, 'destroy'])->name('admin.pages.destroy');

	//FAQs Settings
    Route::get('/faqs/list', [FaqsController::class, 'index'])->name('admin.faqs.list');
    Route::post('/faqs/add', [FaqsController::class, 'store'])->name('admin.faqs.add');
    Route::get('/faqs/edit', [FaqsController::class, 'edit'])->name('admin.faqs.edit');
    Route::post('/faqs/update', [FaqsController::class, 'update'])->name('admin.faqs.update');
	Route::post('/faqs/destroy', [FaqsController::class, 'destroy'])->name('admin.faqs.destroy');

	//Deposits
    Route::get('/deposits', [PaymentsController::class, 'deposits'])->name('admin.deposits');
    Route::get('/deposits/view/{id}', [PaymentsController::class, 'deposits_view'])->name('admin.deposits.view');
	Route::post('/deposits/approve', [PaymentsController::class, 'deposits_approve'])->name('admin.deposits.approve');
	Route::post('/deposits/reject', [PaymentsController::class, 'deposits_reject'])->name('admin.deposits.reject');

	//Withdrawals
    Route::get('/withdrawals', [PaymentsController::class, 'withdrawals'])->name('admin.withdrawals');
    Route::post('/withdrawals/paid', [PaymentsController::class, 'paid'])->name('admin.withdrawals.paid');
    Route::post('/withdrawals/unpaid', [PaymentsController::class, 'unpaid'])->name('admin.withdrawals.unpaid');

    //Earnings
    Route::get('/earnings', [PaymentsController::class, 'earnings'])->name('admin.earnings');

	//Categories Settings
    Route::get('/categories/list', [CategoriesController::class, 'index'])->name('admin.categories.list');
    Route::post('/categories/add', [CategoriesController::class, 'store'])->name('admin.categories.add');
    Route::get('/categories/edit', [CategoriesController::class, 'edit'])->name('admin.categories.edit');
    Route::post('/categories/update', [CategoriesController::class, 'update'])->name('admin.categories.update');
	Route::post('/categories/destroy', [CategoriesController::class, 'destroy'])->name('admin.categories.destroy');

	//Payouts Settings
    Route::get('/payouts/list', [PayoutsController::class, 'index'])->name('admin.payouts.list');
    Route::post('/payouts/add', [PayoutsController::class, 'store'])->name('admin.payouts.add');
    Route::get('/payouts/edit', [PayoutsController::class, 'edit'])->name('admin.payouts.edit');
    Route::post('/payouts/update', [PayoutsController::class, 'update'])->name('admin.payouts.update');
	Route::post('/payouts/destroy', [PayoutsController::class, 'destroy'])->name('admin.payouts.destroy');

    //Videos
    Route::get('/videos/list', [AdminController::class, 'list_videos'])->name('admin.videos.list');
    Route::get('/videos/edit/{id}', [AdminController::class, 'edit_videos'])->name('admin.videos.edit');
    Route::post('/videos/edit/{id}', [AdminController::class, 'update_videos']);
	Route::post('/videos/destroy', [AdminController::class, 'destroy_videos'])->name('admin.videos.destroy');
    Route::get('/videos/view/{id}', [AdminController::class, 'view_videos'])->name('admin.videos.view');

    //Views
    Route::get('/viewers', [AdminController::class, 'viewers'])->name('admin.viewers');

});
