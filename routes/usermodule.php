<?php

use Illuminate\Support\Facades\Route;

/* Google Login*/
Route::group(['namespace' => 'Auth\Frontend'], function(){

    Route::get('login', 'GoogleOAuthController@showLogin')->name('premiumlogin')->middleware('guest:web');
    Route::post('login', 'LoginController@attemptLogin')->name('login');
    Route::get('auth/google', 'GoogleOAuthController@redirectToGoogle')->name('google.oauth.login');
    Route::get('auth/google/callback','GoogleOAuthController@handleGoogleCallback')->name('callbacklogin');
    Route::post('logout', 'LoginController@logout')->name('logout');
});
/* End of google login */

Route::post('/payment-hook', 'Hooks\PaymentHookController@payment');
Route::get('/payment-hook-response', 'Hooks\PaymentHookController@response');


Route::group(['namespace' => 'Frontend\Dashboard'], function(){

    Route::get('/', 'UserDashboardController@index')->name('userdashboard');
    Route::post('shareIndividual', 'UserDashboardController@shareNews')->name('share');
    Route::get('status', 'UserDashboardController@getStatus')->name('getstatus');
    Route::post('addtofav', 'UserDashboardController@addToFav')->name('addfav');
    Route::get('claps', 'UserDashboardController@addClaps')->name('clapping');
    Route::get('sharenews/{id}', 'UserDashboardController@show')->name('newslink');
});



Route::group([
    'prefix'        => 'premium',
    'namespace'     => 'Frontend\Razorpay'
    ],function () {
        Route::get('plans', 'RazorpayController@index')->name('razorpay')->middleware('auth');
        Route::post('plan-confirm', 'RazorpayController@confirm')->name('razorpay.confirm');
        Route::post('razorpaypayment', 'RazorpayController@payment')->name('payment');
        Route::post('order', 'RazorpayController@createOrder')->name('ordergenerate');
        Route::post('promo','RazorpayController@promoValidation')->name('applypromo');
});

Route::resource('premiumarticle','Frontend\Premium\PremiumArticleController')->name('index','premiumarticle')->only(['index']);
Route::resource('userscore', 'Frontend\Score\ScoreController')->name('index','userscore')->only(['index']);
Route::resource('userinfographics', 'Frontend\Info\InfoGraphics')->name('index','userinfographics')->only(['index']);
Route::resource('userdiscover','Frontend\Discover\DiscoverController')->name('index','userdiscover')->only(['index']);

Route::resource('userproduct','Frontend\Product\ProductController')->name('index','product')->only(['index']);
Route::resource('fav', 'Frontend\Favourites\FavNewsController')->name('index','favnews')->only(['index']);

Route::get('invite', ['uses'=>'Frontend\Invite\InviteController@index','as'=> 'invite']);
Route::get('userprofile','Frontend\Profile\ProfileController@index')->middleware('auth:web')->name('profile');
Route::get('showchangePassword','Frontend\Profile\ProfileController@changePasswordShow')->middleware('auth:web')->name('changepasswordshow');
Route::post('changePassword','Frontend\Profile\ProfileController@updatePassword')->middleware('auth:web')->name('changepassword');
Route::post('changemobile','Frontend\Profile\ProfileController@updateMobile')->middleware('auth:web')->name('changemobile');

Route::get('privacy','Frontend\Privacy\PrivacyController@showPrivacy')->name('privacy');
Route::get('policy','Frontend\Privacy\PrivacyController@showPolicy')->name('policy');
Route::get('terms','Frontend\Privacy\PrivacyController@showTerms')->name('terms');