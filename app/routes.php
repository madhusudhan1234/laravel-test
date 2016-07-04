<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*Route::get('users/register', function()
{
	return View::make('hello');
});*/

Route::get('users/register','HomeController@getRegister');

Route::get('users/login','HomeController@getLogin');
Route::post('users/login','HomeController@PostLogin');
Route::get('logout','HomeController@getLogout');

Route::get('/',['as'=>'home','uses'=>'HomeController@index']);

Route::resource('users','UserController');
Route::resource('products','ProductController');

// Add this route for checkout or submit form to pass the item into paypal
Route::post('payment', array(
	'as' => 'payment',
	'uses' => 'PaypalController@postPayment',
));

// this is after make the payment, PayPal redirect back to your site
Route::get('payment/status', array(
	'as' => 'payment.status',
	'uses' => 'PaypalController@getPaymentStatus',
));
