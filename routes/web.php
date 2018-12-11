<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Install app

Route::get('/app/check', function() {

});

/*
 * Play domain
 */

Route::group(['domain' => 'play.' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN')], function () {

    /*
     * Main game
     */

    Route::get('/', 'Showcase\PlayController@index')->name('play.game');

    ///
    // Registration
    ///

    Route::get('/quest/redirect', 'Showcase\RegisterController@getRedirectTo')->name('play.redirect.to');
    Route::get('/register', 'Showcase\RegisterController@getRegister')->name('play.register.form');
    Route::post('/register', 'Showcase\RegisterController@register');

    /*
     * Check code
     */
    Route::get('/check_code', 'Showcase\CodeCheckController@getCheckCode')->name('play.check.form');
    Route::post('/check_code', 'Showcase\CodeCheckController@checkCode');


    /*
     * Select Payments
     */
    Route::get('/get_payment', 'Showcase\PaymentController@index')->name('play.get_payment.form');
    Route::post('/get_payment', 'Showcase\PaymentController@postSelected');

    /*
     * PayPal
     */
    Route::get('/quest/get_paypal', 'Showcase\PaypalController@payPalForm')->name('paypal.form');

    /*
     *  Paypal and PIN Payment (check paid)
     */
    Route::get('/quest/payment_success', 'Showcase\PaymentController@getSuccess')->name('show.success');
    Route::post('/quest/payment_success', 'Showcase\PaymentController@success');

    /*
     * Pin Payment
     */
    Route::get('/quest/get_pin_payment', 'Showcase\PinPaymentController@payPinPaymentForm')->name('pin_payment.form');
    Route::get('quest/pin_payment_action', 'Showcase\PinPaymentController@postPinPayment');


});

Route::group(['domain' => 'play.' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN'), 'middleware' => 'user_auth'], function () {

    //Route::get('/point', 'Showcase\PlayController@model_point')->name('play.point');
    //Route::post('/point', 'Showcase\PlayController@model_check_answer')->name('play.answer');
    //Route::get('/end', 'Showcase\PlayController@model_end')->name('play.end');
});

/*
 * Sub Domain
 */

Route::group(['domain' => '{domain}.' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN')], function () {

    Route::get('/', 'Showcase\LandingController@getLanding');
    Route::get('/route/{route}', 'Showcase\RouteController@domainIndex');
    /*
    * Demo
    */
    Route::get('/demo', 'Showcase\PlayController@getDemo');
});

Route::group(['domain' => 'www.{domain}.' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN')], function () {

    Route::get('/', 'Showcase\LandingController@getLanding');
    Route::get('/route/{route}', 'Showcase\RouteController@domainIndex');
    /*
    * Demo
    */
    Route::get('/demo', 'Showcase\PlayController@getDemo');
});


/*
 * Main Domain
 */

Route::get('/test/session', function() { dd(session('domain')); });

Route::get('/', 'Showcase\LandingController@index');
Route::get('/info/main', 'Showcase\LandingController@index');
Route::get('/route/{slug}', 'Showcase\RouteController@index');

// PayPal listener
Route::post('/listener', 'Showcase\PaypalController@ipnListener');

// Temporary for landing
Route::get('/landing/{domain}', 'Showcase\LandingController@getLanding');
Route::get('landing/{domain}/route/{route}', 'Showcase\RouteController@domainIndex');
Route::get('/landing/{domain}/demo', 'Showcase\PlayController@getDemo');
/*
    * Demo
    */
Route::get('/demo', 'Showcase\PlayController@getMainDemo')->name('showcase.demo');

/*
 * Info pages
 */
Route::get('/info/{slag}', 'Showcase\LandingController@getInfoPage');


/*
 * Admin Auth
 */

Route::group(['domain' => getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN')], function () {

    Auth::routes();
    Route::get('/home', function(){
        return redirect()->to('/admin');
    });
});


/*
 * Admin Panel
 */

Route::group(['middleware' => 'auth'], function() {

    Route::get('/logout', 'Admin\AuthController@logout');
});


/*
 * Access for all Admins
 */

Route::group([
        'prefix'     => 'admin',
        'middleware' => ['auth', 'roles'],
        'roles'      => ['global', 'admin', 'contributor', 'api']
    ], function() {

    Route::get('/', 'Admin\AdminController@index');

});

/*
 * Access for Global Admin
 */

Route::group([
    'prefix'     => 'admin',
    'middleware' => ['auth', 'roles'],
    'roles'      => 'global'
], function() {

    // API Documentation
    Route::get('/api', 'Api\DocumentationController@index');

    // Profile
    Route::post('/profile', 'Admin\ProfileController@update');

    // Delete codes
    Route::get('/code/delete-older-1-year', 'Admin\CodeController@destroy1year');

    // Domains
    Route::get('/domain', 'Admin\DomainController@getList')->name('admin.domain.list');
    Route::get('/domain/edit/{domain}', 'Admin\DomainController@edit');
    Route::post('/domain/edit/{domain}', 'Admin\DomainController@update');
    Route::get('/domain/create', 'Admin\DomainController@create');
    Route::post('/domain/create', 'Admin\DomainController@store');
    Route::get('/domain/delete/{domain}', 'Admin\DomainController@destroy');

    // Partners
    Route::get('/partner', 'Admin\PartnerController@getList')->name('admin.partner.list');
    Route::get('/partner/edit/{partner}', 'Admin\PartnerController@edit');
    Route::post('/partner/edit/{domain}', 'Admin\PartnerController@update');
    Route::get('/partner/create', 'Admin\PartnerController@create');
    Route::post('/partner/create', 'Admin\PartnerController@store');
    Route::get('/partner/delete/{partner}', 'Admin\PartnerController@destroy');

    // Admins
    Route::get('/admin', 'Admin\PartnerAdminController@getList')->name('admin.user.admin.list');
    Route::get('/admin/edit/{user}', 'Admin\PartnerAdminController@edit');
    Route::post('/admin/edit/{user}', 'Admin\PartnerAdminController@update');
    Route::get('/admin/create', 'Admin\PartnerAdminController@create');
    Route::post('/admin/create', 'Admin\PartnerAdminController@store');
    Route::get('/admin/delete/{user}', 'Admin\PartnerAdminController@destroy');

    // Landings
    Route::get('/landing', 'Admin\LandingController@getList');
    Route::get('/landing/delete/{landing}', 'Admin\LandingController@destroy');

    // Paypal transactions
    Route::get('/paypal', 'Admin\PaypalController@getList');
    Route::get('/paypal/csv', 'Admin\PaypalController@generateExcel');

    // PIN Payment transactions
    Route::get('/pin', 'Admin\PinController@getList');
    Route::get('/pin/csv', 'Admin\PinController@generateExcel');

    // Categories
    Route::get('/category', 'Admin\CategoryController@getList')->name('admin.category.list');
    Route::get('/category/{category}/route', 'Admin\RouteController@getListFromCategory')->name('admin.category.route.list');
    Route::get('/category/edit/{category}', 'Admin\CategoryController@edit');
    Route::post('/category/edit/{category}', 'Admin\CategoryController@update');
    Route::get('/category/create', 'Admin\CategoryController@create');
    Route::post('/category/create', 'Admin\CategoryController@store');
    Route::get('/category/delete/{user}', 'Admin\CategoryController@destroy');

});

/*
 * Access for Admins and Global Admins
 */

Route::group([
    'prefix'     => 'admin',
    'middleware' => ['auth', 'roles'],
    'roles'      => ['global', 'admin']
], function() {

    // Code load to Excel
    Route::get('/code/csv', 'Admin\CodeController@generateExcel');

    // Contributors
    Route::get('/contributor', 'Admin\ContributorController@getList')->name('admin.user.contributor.list');
    Route::get('/contributor/edit/{user}', 'Admin\ContributorController@edit');
    Route::post('/contributor/edit/{user}', 'Admin\ContributorController@update');
    Route::get('/contributor/create', 'Admin\ContributorController@create');
    Route::post('/contributor/create', 'Admin\ContributorController@store');
    Route::get('/contributor/delete/{user}', 'Admin\ContributorController@destroy');

    // Landing
    Route::post('/landing/edit/{landing}', 'Admin\LandingController@update');
    Route::get('/landing/preview', 'Admin\LandingController@preview');
    Route::post('/landing/preview/{landing}', 'Admin\LandingController@previewUpdate');
    Route::get('/landing/show/{landing}', 'Admin\LandingController@showPreview');
    // Delete Images
    Route::get('/landing/{landing}/delete/image', 'Admin\LandingController@destroyImage');


    // Reports
    Route::get('/report/tables', 'Admin\ReportController@general');
    Route::get('/report/detailed', 'Admin\ReportController@detail');
    Route::get('/report/dashboard', 'Admin\ReportController@dashboard');
    Route::get('/report/tables/csv', 'Admin\ReportController@generalCSV');
    Route::get('/report/detailed/csv', 'Admin\ReportController@detailCSV');
    Route::get('/report/dashboard', 'Admin\ReportController@dashboard');
});

/*
 * Access for Admins
 */

Route::group([
    'prefix'    => 'admin',
    'middleware'=> ['auth', 'roles'],
    'roles'     => ['admin']
], function() {

    // Tours
    Route::get('/route/create', 'Admin\RouteController@create');
    Route::post('/route/create', 'Admin\RouteController@store');
    Route::get('/route/delete/{route}', 'Admin\RouteController@destroy');
});

/*
 * Access for Admins and Contributors
 */

Route::group([
    'prefix'    => 'admin',
    'middleware'=> ['auth', 'roles'],
    'roles'     => ['admin', 'contributor']
], function() {

    // Tours
    Route::get('/route/edit/{route}', 'Admin\RouteController@edit');
    Route::post('/route/edit/{route}', 'Admin\RouteController@update');
});

/*
 * Access for Contributors, Admins and Global Admins
 */

Route::group([
    'prefix'     => 'admin',
    'middleware' => ['auth', 'roles'],
    'roles'      => ['global', 'admin', 'contributor']
], function() {

    //Tours
    Route::get('/route', 'Admin\RouteController@getList')->name('admin.route.list');

    // Route usability
    Route::post('/route/{route}/point/create' , 'Admin\PointController@storeInRoute');
    Route::post('/route/{route}/point/edit/{point}' , 'Admin\PointController@updateInRoute');
    Route::get('/route/{route}/point/delete/{point}' , 'Admin\PointController@destroyInRoute');
    Route::get('/route/{route}/point/move_up/{point}' , 'Admin\PointController@moveUp');
    Route::get('/route/{route}/point/move_down/{point}' , 'Admin\PointController@moveDown');

    Route::get('/point/{point}/answer', 'Admin\AnswerController@getListInRoute');
    Route::get('/point/{point}/hint', 'Admin\HintController@getListInRoute');



    //Codes
    Route::post('/code/generate', 'Admin\CodeController@store');
    Route::get('/code/active/{code}', 'Admin\CodeController@activate');
    Route::get('/code/de_active/{code}', 'Admin\CodeController@deActivate');
    Route::get('/code/delete/{code}', 'Admin\CodeController@destroy');
});


/*
 * Access for globals
 */
Route::group([
    'prefix'     => 'admin',
    'middleware' => ['auth', 'roles'],
    'roles'      => ['global']
], function() {

});

/*
 * Codes
 */

Route::group([
    'prefix'     => 'admin',
    'middleware' => ['auth', 'roles'],
    'roles'      => ['api', 'global', 'admin', 'contributor']
], function() {

    Route::get('/code', 'Admin\CodeController@getList');
});

/*
 * Access for API
 */


Route::group([
    'prefix'     => 'admin',
    'middleware' => ['auth', 'roles'],
    'roles'      => ['api', 'global']
], function() {

    // API Documentation
    Route::get('/api', 'Api\DocumentationController@index');
});

