<?php

use Illuminate\Support\Facades\Route;


Route::get('admin', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::get('admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('admin/login', 'Auth\AdminLoginController@attemptLogin')->name('admin.login');
Route::post('admin/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

Route::group(['prefix' => 'admin','middleware' => 'auth:admin', 'namespace'=>'Admin'], function () {

    Route::get('/home', 'HomeController@index')->name('admin.dashboard');

    Route::resource('/discover', 'DiscoverController');
    Route::resource('/statusBar', 'StatusBarController');
    Route::resource('/news', 'NewsController');
    Route::resource('/scoreBoard', 'ScoreBoardController');

    Route::get('/front-end-users/show-user-scratch-attempts',['as'=>'front-end-users.show_scratch_attempts','uses'=>'UserAccessController@show_userScratch_Attempts']);

    Route::get('/front-end-users/show-user-coin-reedem-log','UserAccessController@show_userCoin_Reedem_Log')->name('front-end-users.show_coin_reedem_log');

    Route::get('/front-end-users/show-user-coin-reedem-index','UserAccessController@coinindex')->name('front-end-users.coinindex');

    Route::get('/front-end-users/show-user-scratched-index','UserAccessController@scratchindex')->name('front-end-users.scratchindex');

    Route::resource('/infoGraphics', 'InfoGraphicsController');
    Route::post('/front-end-users/{uid}/disable-user', 'UserAccessController@disable_user')->name('front-end-users.inactivate');
    Route::get('/front-end-users/{uid}/premium-user-activity', 'UserAccessController@show_premiumUserActivity')->name('front-end-users.premium_user_activity');

    Route::get('/front-end-users/show-user-scratch-attempts',['as'=>'front-end-users.show_scratch_attempts','uses'=>'UserAccessController@show_userScratch_Attempts']);
    Route::resource('/front-end-users', 'UserAccessController');
    Route::resource('/plans', 'PlansController');
    Route::resource('/products', 'ProductController');
    Route::resource('/coupons', 'CouponController');
    Route::resource('/scratchCard', 'ScratchController');
    Route::resource('/promocode', 'PromoCodeController');
});

