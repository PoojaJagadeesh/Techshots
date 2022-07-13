<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([ 'middleware' => ['api'], 'namespace' => 'Api'], function () {

    Route::post('login', 'LoginController@login');
    Route::post('register', 'LoginController@register');

    Route::group(['middleware' => 'jwt.verify'], function(){

        Route::post('logout', 'LoginController@logout');
        Route::post('refresh', 'LoginController@refresh');
        Route::get('detail', 'LoginController@detail');
        Route::get('profile', 'AppNecessaryDataController@profile');

        Route::get('status', 'StatusController@index');
        Route::get('news', 'NewsController@news');
        Route::get('news/favourites', 'NewsController@fetch_favourites');
        Route::get('news/lite_infos', 'NewsController@lite_news_infos_toAll');
        Route::get('news/read', 'NewsController@read_news');
        Route::post('news/add_to_favourites', 'NewsController@add_news_to_favouites');
        Route::post('news/add_claps', 'NewsController@add_claps');
        Route::get('discover', 'DiscoverController@discover');
        Route::get('scoreboard', 'ApiController@scoreboard');
        Route::get('infographics', 'InfoGraphicsController@infographic');
        Route::get('products', 'ProductController@products');
        Route::get('plans', 'AppNecessaryDataController@plans');
        Route::post('plans/add_payment_response', 'AppNecessaryDataController@addPaymentreponses');

        Route::get('coins/add_initial_coins', 'AppNecessaryDataController@add_initialcoins');
        Route::get('coins/show_remaining_coins', 'AppNecessaryDataController@retrieve_remainingUserCoins');
        Route::get('coins/active_coupon_lists', 'AppNecessaryDataController@show_activeCouponLists');
        Route::get('coins/reedemed_coupon_lists', 'AppNecessaryDataController@show_reedemedCouponLists');
        Route::post('coins/reedem_coupon', 'AppNecessaryDataController@make_reedem_coupon');

        Route::get('scratches/create_and_show_scratches', 'ScratchActionController@create_showScratches');
        Route::get('scratches/list_expecting_and_gifted_scratches', 'ScratchActionController@showexpecting_andGiftedScratches');
        Route::get('scratches/popup_the_scratch', 'ScratchActionController@popUpTheCard');
        Route::post('scratches/perform_scratch', 'ScratchActionController@perform_scratchAction');

        Route::get('offers/fetch_all_offers',  'ApiController@fetch_all_offers');
    });

});



