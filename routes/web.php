<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group([
    'prefix' => 'api',
    'middleware' => ['isAuth']
],function (){
    Route::resource('shoes','App\Http\Controllers\ShoesController');

    Route::resource('purpose','App\Http\Controllers\PurposeController');

    Route::resource('weather','App\Http\Controllers\WeatherController');
});

Route::group(['prefix'=>'auth','as' => 'auth.'],function (){
    Route::get('signin','App\Http\Controllers\Auth\SignInController@signinForm')->name('signin-form');
    Route::post('signin','App\Http\Controllers\Auth\SignInController@signin')->name('signin');
    Route::get('signup','App\Http\Controllers\Auth\SignUpController@registration')->name('signup-form');
    Route::post('signup','App\Http\Controllers\Auth\SignUpController@registration')->name('signup');

    Route::get('signout','App\Http\Controllers\Auth\SignInController@signout')->name('signout');

    Route::match(['post','get'],'forgot-password','App\Http\Controllers\Auth\ResetPasswordController@resetPassword')->name('reset-password');

});

Route::match(['get','post'],'reset-password','App\Http\Controllers\Auth\ResetPasswordController@confirmResetPassword')->name('password.reset');

Route::get('/',function (){
    return view('welcome');
})->name('home')->middleware('isAuth');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any','.*')->middleware('isAuth');

