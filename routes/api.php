<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Countries & States
Route::apiResource('state', 'App\Http\Controllers\StateController');
Route::apiResource('country', 'App\Http\Controllers\CountryController');

// Settings & Theme Options
Route::get('settings', 'App\Http\Controllers\SettingController@index');
Route::get('app/settings', 'App\Http\Controllers\AppSettingController@index');
Route::get('themeOptions', 'App\Http\Controllers\ThemeOptionController@index');

// Webhooks
Route::post('/paypal/webhook', 'App\Http\Controllers\WebhookController@paypal')->name('paypal.webhook');
Route::post('/razorpay/webhook', 'App\Http\Controllers\WebhookController@razorpay')->name('razorpay.webhook');
Route::post('/stripe/webhook', 'App\Http\Controllers\WebhookController@stripe')->name('stripe.webhook');
Route::post('/mollie/webhook', 'App\Http\Controllers\WebhookController@mollie')->name('mollie.webhook');
Route::post('/instamojo/webhook', 'App\Http\Controllers\WebhookController@instamojo')->name('instamojo.webhook');
Route::post('/ccavenue/webhook', 'App\Http\Controllers\WebhookController@ccavenue')->name('ccavenue.webhook');
Route::get('/flutterwave/webhook', 'App\Http\Controllers\WebhookController@flutterwave')->name('flutterwave.webhook');
Route::post('/sslcommerz/webhook', 'App\Http\Controllers\WebhookController@sslcommerz')->name('sslcommerz.webhook');

// Authentication
Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/backend/login', 'App\Http\Controllers\AuthController@backendLogin');
Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/forgot-password', 'App\Http\Controllers\AuthController@forgotPassword');
Route::post('/verify-token', 'App\Http\Controllers\AuthController@verifyToken');
Route::post('/update-password', 'App\Http\Controllers\AuthController@updatePassword');

// Menus
Route::apiResource('menu', 'App\Http\Controllers\MenuController',[
  'only' => ['index', 'show'],
]);

// Products
Route::apiResource('product', 'App\Http\Controllers\ProductController',[
  'only' => ['index', 'show'],
]);
Route::get('collection/sidebar', 'App\Http\Controllers\ProductController@collection');
Route::get('product/slug/{slug}', 'App\Http\Controllers\ProductController@getProductBySlug');
Route::get('product/id/{id}', 'App\Http\Controllers\ProductController@getProductsByIDRange');
Route::get('product/minify/list', 'App\Http\Controllers\ProductController@getMinifyProduct');

// Attributes
Route::apiResource('attribute', 'App\Http\Controllers\AttributeController',[
  'only' => ['index', 'show'],
]);

// Attribute Values
Route::apiResource('attribute-value', 'App\Http\Controllers\AttributeValueController',[
  'only' => ['index', 'show'],
]);

// Categories
Route::apiResource('category', 'App\Http\Controllers\CategoryController',[
  'only' => ['index', 'show'],
]);
Route::get('category/slug/{slug}', 'App\Http\Controllers\CategoryController@getCategoryBySlug');

// Tags
Route::apiResource('tag', 'App\Http\Controllers\TagController', [
  'only' => ['index', 'show'],
]);

// Brands
Route::apiResource('brand', 'App\Http\Controllers\BrandController', [
  'only' => ['index', 'show'],
]);
Route::get('brand/slug/{slug}', 'App\Http\Controllers\BrandController@getBrandBySlug');

// Attributes
Route::apiResource('attribute', 'App\Http\Controllers\AttributeController',[
  'only' => ['index', 'show'],
]);
Route::get('attributes/used-in-products', 'App\Http\Controllers\AttributeController@attributesUsedInProducts');

// Stores
Route::apiResource('store', 'App\Http\Controllers\StoreController',[
  'only' => ['index', 'show'],
]);
Route::post('store', 'App\Http\Controllers\StoreController@store');
Route::get('store/slug/{slug}', 'App\Http\Controllers\StoreController@getStoreBySlug');

// Order Status
Route::apiResource('orderStatus', 'App\Http\Controllers\OrderStatusController',[
  'only' => ['index', 'show'],
]);

// Blogs
Route::apiResource('blog', 'App\Http\Controllers\BlogController', [
  'only' => ['index', 'show'],
]);
Route::get('blog/slug/{slug}', 'App\Http\Controllers\BlogController@getBlogBySlug');

// Pages
Route::apiResource('page', 'App\Http\Controllers\PageController', [
  'only' => ['index', 'show'],
]);
Route::get('page/slug/{slug}', 'App\Http\Controllers\PageController@getPagesBySlug');
//Route::match(['get', 'put'],'page/slug/{slug}', 'App\Http\Controllers\PageController@getPagesBySlug');

// Taxes
Route::apiResource('tax', 'App\Http\Controllers\TaxController', [
  'only' => ['index', 'show'],
]);

// Coupons
Route::apiResource('coupon', 'App\Http\Controllers\CouponController', [
  'only' => ['index', 'show'],
]);

// Currencies
Route::apiResource('currency', 'App\Http\Controllers\CurrencyController', [
  'only' => ['index', 'show'],
]);

// Faqs
Route::apiResource('faq', 'App\Http\Controllers\FaqController', [
  'only' => ['index', 'show'],
]);

// Home
Route::apiResource('home', 'App\Http\Controllers\HomePageController', [
  'only' => ['index', 'show'],
]);

// Theme
Route::apiResource('theme', 'App\Http\Controllers\ThemeController',[
  'only' => ['index', 'show'],
]);

// Question & Answer
Route::apiResource('question-and-answer', 'App\Http\Controllers\QuestionAndAnswerController',[
  'only' => ['index', 'show'],
]);

// Subscribe
Route::apiResource('subscribe', 'App\Http\Controllers\SubscribeController',[
  'only' => ['store'],
]);

// Reviews
Route::get('front/review', 'App\Http\Controllers\ReviewController@frontIndex');

// ContactUs
Route::post('/contact-us', 'App\Http\Controllers\ContactUsController@contactUs');

// Checkout
Route::post('checkout','App\Http\Controllers\CheckoutController@verifyCheckout');

// Place Order
Route::post('order', 'App\Http\Controllers\OrderController@store');

// Track Order
Route::any('trackOrder/{uuid?}', 'App\Http\Controllers\OrderController@trackOrder');

// get Invoice Order
Route::get('order/invoice/{invoice}', 'App\Http\Controllers\OrderController@getInvoice');

// Download Files
Route::get('download/zip/file/{token}/{id}', 'App\Http\Controllers\DownloadController@downloadZip')->middleware('signed')->name('download.zip.link');
Route::get('download/key/file/{token}/{id}', 'App\Http\Controllers\DownloadController@downloadKey')->middleware('signed')->name('download.key.link');
Route::get('download/admin/zip/file/{product_id}/{variation_id?}', 'App\Http\Controllers\DownloadController@adminDownloadZip')->middleware('signed')->name('admin.download.zip.link');

Route::group(['middleware' => ['localization','auth:sanctum']], function () {

  // Authentication
  Route::post('logout', 'App\Http\Controllers\AuthController@logout');

  // Account
  Route::get('self', 'App\Http\Controllers\AccountController@self');
  Route::put('updateProfile', 'App\Http\Controllers\AccountController@updateProfile');
  Route::put('updatePassword', 'App\Http\Controllers\AccountController@updatePassword');
  Route::put('updateProfile', 'App\Http\Controllers\AccountController@updateProfile');
  Route::put('updatePassword', 'App\Http\Controllers\AccountController@updatePassword');
  Route::put('updateStoreProfile', 'App\Http\Controllers\AccountController@updateStoreProfile');

  // Address
  Route::apiResource('address', 'App\Http\Controllers\AddressController');

  // Payment Account
  Route::apiResource('paymentAccount', 'App\Http\Controllers\PaymentAccountController');

  // Badge
  Route::get('badge','App\Http\Controllers\BadgeController@index');

  // Notifications
  Route::get('notifications', 'App\Http\Controllers\NotificationController@index');
  Route::put('notifications/markAsRead', 'App\Http\Controllers\NotificationController@markAsRead');
  Route::delete('notifications/{id}', 'App\Http\Controllers\NotificationController@destroy');
  Route::post('notifications/test', 'App\Http\Controllers\NotificationController@test');

  // ***********  Frontend   ***********
  Route::apiResource('cart', 'App\Http\Controllers\CartController');
  Route::apiResource('refund', 'App\Http\Controllers\RefundController');
  Route::apiResource('compare', 'App\Http\Controllers\CompareController');
  Route::apiResource('wishlist', 'App\Http\Controllers\WishlistController');

  Route::post('rePayment', 'App\Http\Controllers\OrderController@rePayment');
  Route::get('verifyPayment/{order_number}', 'App\Http\Controllers\OrderController@verifyPayment');

  Route::put('cart', 'App\Http\Controllers\CartController@update');
  Route::post('sync/cart', 'App\Http\Controllers\CartController@sync');
  Route::put('replace/cart', 'App\Http\Controllers\CartController@replace');
  Route::delete('clear/cart', 'App\Http\Controllers\CartController@clear');

  // **********************  Backend   *******************************

  // Dashboard
  Route::get('statistics/count', 'App\Http\Controllers\DashboardController@index');
  Route::get('dashboard/chart', 'App\Http\Controllers\DashboardController@chart');

  // Users
  Route::apiResource('user', 'App\Http\Controllers\UserController');
  Route::put('user/{id}/{status}', 'App\Http\Controllers\UserController@status')->middleware('can:user.edit');
  Route::post('user/csv/import', 'App\Http\Controllers\UserController@import')->middleware('can:user.create');
  Route::post('user/csv/export', 'App\Http\Controllers\UserController@export')->name('users.export')->middleware('can:user.index');
  Route::post('user/deleteAll', 'App\Http\Controllers\UserController@deleteAll')->middleware('can:user.destroy');
  Route::delete('user/address/{id}', 'App\Http\Controllers\UserController@deleteAddress')->middleware('can:user.edit');

  //Roles
  Route::apiResource('role', 'App\Http\Controllers\RoleController');
  Route::get('module', 'App\Http\Controllers\RoleController@modules');
  Route::post('role/deleteAll', 'App\Http\Controllers\RoleController@deleteAll')->middleware('can:role.destroy');

  // Products
  Route::apiResource('product', 'App\Http\Controllers\ProductController', [
    'only' => ['store', 'update', 'destroy'],
  ]);
  Route::post('product/replicate', 'App\Http\Controllers\ProductController@replicate')->middleware('can:product.edit');
  Route::put('product/{id}/{status}', 'App\Http\Controllers\ProductController@status')->middleware('can:product.edit');
  Route::post('product/csv/export', 'App\Http\Controllers\ProductController@export')->name('products.export')->middleware('can:product.index');
  Route::post('product/csv/import', 'App\Http\Controllers\ProductController@import')->middleware('can:product.create');
  Route::put('product/approve/{id}/{status}', 'App\Http\Controllers\ProductController@approve')->middleware('can:product.edit');
  Route::post('product/deleteAll', 'App\Http\Controllers\ProductController@deleteAll')->middleware('can:product.destroy');

  // Attributes & Attribute Values
  Route::apiResource('attribute', 'App\Http\Controllers\AttributeController',[
    'only' => ['store', 'update', 'destroy'],
  ]);
  Route::apiResource('attribute-value', 'App\Http\Controllers\AttributeValueController',[
    'only' => ['store', 'update', 'destroy'],
  ]);
  Route::put('attribute/{id}/{status}', 'App\Http\Controllers\AttributeController@status')->middleware('can:attribute.edit');
  Route::post('attribute/csv/import', 'App\Http\Controllers\AttributeController@import')->middleware('can:attribute.create');
  Route::post('attribute/csv/export', 'App\Http\Controllers\AttributeController@export')->name('attributes.export')->middleware('can:attribute.index');
  Route::post('attribute/deleteAll', 'App\Http\Controllers\AttributeController@deleteAll')->middleware('can:attribute.destroy');

  // Categories
  Route::apiResource('category', 'App\Http\Controllers\CategoryController',[
    'only' => ['store', 'update', 'destroy'],
  ]);
  Route::post('category/csv/import', 'App\Http\Controllers\CategoryController@import')->middleware('can:category.create');
  Route::post('category/csv/export', 'App\Http\Controllers\CategoryController@export')->name('categories.export')->middleware('can:category.index');
  Route::put('category/{id}/{status}', 'App\Http\Controllers\CategoryController@status')->middleware('can:category.edit');

  // Tags
  Route::apiResource('tag', 'App\Http\Controllers\TagController',[
    'only' => ['store', 'update', 'destroy'],
  ]);
  Route::post('tag/csv/import', 'App\Http\Controllers\TagController@import')->middleware('can:tag.create');
  Route::post('tag/csv/export', 'App\Http\Controllers\TagController@export')->name('tags.export')->middleware('can:tag.index');
  Route::post('tag/deleteAll', 'App\Http\Controllers\TagController@deleteAll')->middleware('can:tag.destroy');
  Route::put('tag/{id}/{status}', 'App\Http\Controllers\TagController@status')->middleware('can:tag.edit');

  // Brands
  Route::apiResource('brand', 'App\Http\Controllers\BrandController', [
    'only' => ['store', 'update', 'destroy'],
  ]);
  Route::post('brand/csv/import', 'App\Http\Controllers\BrandController@import')->middleware('can:brand.create');
  Route::post('brand/csv/export', 'App\Http\Controllers\BrandController@export')->name('brands.export')->middleware('can:brand.index');
  Route::post('brand/deleteAll', 'App\Http\Controllers\BrandController@deleteAll')->middleware('can:brand.destroy');
  Route::put('brand/{id}/{status}', 'App\Http\Controllers\BrandController@status')->middleware('can:brand.edit');

  // License Keys
  Route::apiResource('license-key', 'App\Http\Controllers\LicenseKeyController');
  Route::post('license-key/csv/import', 'App\Http\Controllers\LicenseKeyController@import')->middleware('can:license_key.create');
  Route::post('license-key/csv/export', 'App\Http\Controllers\LicenseKeyController@export')->name('license_keys.export')->middleware('can:license_key.index');
  Route::post('license-key/deleteAll', 'App\Http\Controllers\LicenseKeyController@deleteAll')->middleware('can:license_key.destroy');
  Route::put('license-key/{id}/{status}', 'App\Http\Controllers\LicenseKeyController@status')->middleware('can:license_key.edit');

  // Stores
  Route::apiResource('store', 'App\Http\Controllers\StoreController',[
    'only' => ['update', 'destroy'],
  ]);
  Route::post('store/deleteAll', 'App\Http\Controllers\StoreController@deleteAll')->middleware('can:store.destroy');
  Route::put('store/approve/{id}/{status}', 'App\Http\Controllers\StoreController@approve')->middleware('can:store.edit');
  Route::put('store/{id}/{status}', 'App\Http\Controllers\StoreController@status')->middleware('can:store.edit');

  // Vendor Wallets
  Route::get('wallet/vendor', 'App\Http\Controllers\VendorWalletController@index')->middleware('can:vendor_wallet.index');
  Route::post('debit/vendorWallet','App\Http\Controllers\VendorWalletController@debit')->middleware('can:vendor_wallet.debit');
  Route::post('credit/vendorWallet','App\Http\Controllers\VendorWalletController@credit')->middleware('can:vendor_wallet.credit');

  // Commission Histories
  Route::apiResource('commissionHistory', 'App\Http\Controllers\CommissionHistoryController',[
    'only' => ['index', 'show'],
  ]);

  // Withdraw Request
  Route::apiResource('withdrawRequest', 'App\Http\Controllers\WithdrawRequestController');

  // Orders
  Route::apiResource('order', 'App\Http\Controllers\OrderController',[
    'only' => ['index','show', 'update', 'destroy'],
  ]);
  Route::post('cancel/order', 'App\Http\Controllers\OrderController@cancel');
  Route::post('rePayment', 'App\Http\Controllers\OrderController@rePayment');
  Route::get('verifyPayment/{order_number}', 'App\Http\Controllers\OrderController@verifyPayment');

  // Download File
  Route::apiResource('download', 'App\Http\Controllers\DownloadController');
  Route::post('download/zip/link', 'App\Http\Controllers\DownloadController@downloadZipLink');
  Route::post('download/key/link', 'App\Http\Controllers\DownloadController@downloadKeyLink');
  Route::post('download/admin/zip/link', 'App\Http\Controllers\DownloadController@adminDownloadZipLink');

  // Order Status
  Route::apiResource('orderStatus', 'App\Http\Controllers\OrderStatusController',[
    'only' => ['store', 'update', 'destroy'],
  ]);
  Route::post('orderStatus/deleteAll', 'App\Http\Controllers\OrderStatusController@deleteAll')->middleware('can:order_status.destroy');
  Route::put('orderStatus/{id}/{status}', 'App\Http\Controllers\OrderStatusController@status')->middleware('can:order_status.edit');

  // Attachments
  Route::apiResource('attachment', 'App\Http\Controllers\AttachmentController');
  Route::post('attachment/deleteAll', 'App\Http\Controllers\AttachmentController@deleteAll')->middleware('can:attachment.destroy');

  // Blogs
  Route::apiResource('blog', 'App\Http\Controllers\BlogController',[
    'only' => ['store', 'update', 'destroy'],
  ]);
  Route::post('blog/deleteAll', 'App\Http\Controllers\BlogController@deleteAll')->middleware('can:blog.destroy');
  Route::put('blog/{id}/{status}', 'App\Http\Controllers\BlogController@status')->middleware('can:blog.edit');

  // Pages
  Route::apiResource('page', 'App\Http\Controllers\PageController',[
    'only' => ['store', 'update', 'destroy'],
  ]);
  Route::post('page/deleteAll', 'App\Http\Controllers\PageController@deleteAll')->middleware('can:page.destroy');
  Route::put('page/{id}/{status}', 'App\Http\Controllers\PageController@status')->middleware('can:page.edit');

  // Tax
  Route::apiResource('tax', 'App\Http\Controllers\TaxController',[
    'only' => ['store', 'update', 'destroy'],
  ]);
  Route::post('tax/deleteAll', 'App\Http\Controllers\TaxController@deleteAll')->middleware('can:tax.destroy');
  Route::put('tax/{id}/{status}', 'App\Http\Controllers\TaxController@status')->middleware('can:tax.edit');

  // Shipping
  Route::apiResource('shipping', 'App\Http\Controllers\ShippingController');
  Route::put('shipping/{id}/{status}', 'App\Http\Controllers\ShippingController@status')->middleware('can:shipping.edit');

  // Shipping Rule
  Route::apiResource('shippingRule', 'App\Http\Controllers\ShippingRuleController');
  Route::put('shippingRule/{id}/{status}', 'App\Http\Controllers\ShippingRuleController@status')->middleware('can:shipping.edit');

  // Coupon
  Route::apiResource('coupon', 'App\Http\Controllers\CouponController',[
    'only' => ['store', 'update', 'destroy'],
  ]);
  Route::put('coupon/{id}/{status}', 'App\Http\Controllers\CouponController@status')->middleware('can:coupon.edit');
  Route::post('coupon/deleteAll', 'App\Http\Controllers\CouponController@deleteAll')->middleware('can:coupon.destroy');

  // Currencies
  Route::apiResource('currency', 'App\Http\Controllers\CurrencyController',[
    'only' => ['store', 'update', 'destroy'],
  ]);
  Route::put('currency/{id}/{status}', 'App\Http\Controllers\CurrencyController@status')->middleware('can:currency.edit');
  Route::post('currency/deleteAll', 'App\Http\Controllers\CurrencyController@deleteAll')->middleware('can:currency.destroy');

  // Points
  Route::get('points/consumer', 'App\Http\Controllers\PointsController@index')->middleware('can:point.index');
  Route::post('credit/points','App\Http\Controllers\PointsController@credit')->middleware('can:point.credit');
  Route::post('debit/points','App\Http\Controllers\PointsController@debit')->middleware('can:point.debit');

  // Wallets
  Route::get('wallet/consumer', 'App\Http\Controllers\WalletController@index')->middleware('can:wallet.index');
  Route::post('credit/wallet','App\Http\Controllers\WalletController@credit')->middleware('can:wallet.credit');
  Route::post('debit/wallet','App\Http\Controllers\WalletController@debit')->middleware('can:wallet.debit');

  // Reviews
  Route::apiResource('review', 'App\Http\Controllers\ReviewController');
  Route::post('review/deleteAll', 'App\Http\Controllers\ReviewController@deleteAll')->middleware('can:review.destroy');

  // faqs
  Route::apiResource('faq', 'App\Http\Controllers\FaqController',[
    'only' => ['store', 'update', 'destroy'],
  ]);
  Route::put('faq/{id}/{status}', 'App\Http\Controllers\FaqController@status')->middleware('can:faq.edit');
  Route::post('faq/deleteAll', 'App\Http\Controllers\FaqController@deleteAll')->middleware('can:faq.destroy');

  // Question And Answer
  Route::apiResource('question-and-answer', 'App\Http\Controllers\QuestionAndAnswerController', [
    'only' => ['store', 'update', 'destroy'],
  ]);
  Route::post('question-and-answer/feedback', 'App\Http\Controllers\QuestionAndAnswerController@feedback')->middleware('can:question_and_answer.create');

  // Subscribe
  Route::apiResource('subscribe', 'App\Http\Controllers\SubscribeController',[
    'excerpt' => ['create'],
  ]);
  Route::post('subscribe/csv/export', 'App\Http\Controllers\SubscribeController@export')->name('subscribes.export')->middleware('can:subscribe.index');

  // Notice
  Route::get('notice/recent', 'App\Http\Controllers\NoticeController@recentNotice');
  Route::put('notice/markAsRead/{id}', 'App\Http\Controllers\NoticeController@markAsRead');
  Route::post('notice/deleteAll', 'App\Http\Controllers\NoticeController@deleteAll')->middleware('can:notice.destroy');
  Route::apiResource('notice', 'App\Http\Controllers\NoticeController');

  // Themes
  Route::apiResource('theme', 'App\Http\Controllers\ThemeController',[
    'only' => ['update']
  ]);

  // Home
  Route::apiResource('home', 'App\Http\Controllers\HomePageController', [
    'only' => ['update'],
  ]);

  // Theme Options
  Route::put('themeOptions', 'App\Http\Controllers\ThemeOptionController@update')->middleware('can:theme_option.edit');

  // Menus
  Route::apiResource('menu', 'App\Http\Controllers\MenuController',[
    'only' => ['store', 'update', 'destroy'],
  ]);

  // Theme Options
  Route::put('menus', 'App\Http\Controllers\MenuController@update')->middleware('can:menu.edit');

  // App Settings
  Route::put('app/settings', 'App\Http\Controllers\AppSettingController@update')->middleware('can:app_setting.edit');

  // Settings
  Route::put('settings', 'App\Http\Controllers\SettingController@update')->middleware('can:setting.edit');
});
