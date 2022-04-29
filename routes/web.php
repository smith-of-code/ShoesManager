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
    'prefix' => 'api'
],function (){
    Route::resource('shoes','App\Http\Controllers\ShoesController');

    Route::resource('purpose','App\Http\Controllers\PurposeController');

    Route::resource('weather','App\Http\Controllers\WeatherController');
});
Route::group(['prefix'=>'auth','as' => 'auth.'],function (){
    Route::get('signin','App\Http\Controllers\Auth\SignInController@signinForm')->name('signin-form');
    Route::post('signin','App\Http\Controllers\Auth\SignInController@authenticate')->name('signin');
    Route::post('signup','App\Http\Controllers\Auth\SignUpController@registration')->name('signup');
    Route::match(['post','get'],'reset-password','App\Http\Controllers\Auth\ResetPasswordController@resetPassword')->name('reset-password');
});

Route::match(['get','post'],'reset-password','App\Http\Controllers\Auth\ResetPasswordController@confirmResetPassword')->name('password.reset');
Route::get('/{any}', function () {
    return view('welcome');
})->where('any','.*');

