<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return redirect('/documentation/api/rest/swagger/redoc/index.html');
});


$router->post('/v1/stripe/payments/intents', [
    'uses' => 'Payment\Stripe\PaymentIntentController@create',
    'middleware' => 'auth',
    'as'=>'payment-gateway/StripeCreatePaymentIntent'
]);

$router->post('/v1/payments/accounts/{accountId}/cash-in', [
    'uses' => 'Payment\CashIn\IndexController@create',
    'middleware' => 'auth',
    'as'=>'payment-gateway/CreateCashIn'
]);


$router->get('/v1/stripe/payments/form/{amount}/{currency}/{accountId}', 'Payment\Stripe\PaymentIntentController@form');

$router->post('/v1/stripe/payments/intents/webhook', 'Payment\Stripe\PaymentIntentController@webhook');
