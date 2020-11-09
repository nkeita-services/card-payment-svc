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

$router->post('/v1/stripe/payments/webhook', [
    'uses' => 'Payment\Stripe\PaymentIntentController@webhook',
    'as'=>'payment-gateway/StripeWebHook'
]);

$router->post('/v1/stripe/payments/intents/{accountId}', [
    'uses' => 'Payment\Stripe\PaymentIntentController@create',
    'middleware' => 'auth',
    'as'=>'payment-gateway/StripeCreatePaymentIntent'
]);

$router->post('/v1/mtn/payments/accounts/{accountId}/cash-in', [
    'uses' => 'Payment\CashIn\MTN\CashInController@create',
    'middleware' => 'auth',
    'as'=>'payment-gateway/MTNCashIn'
]);

$router->post('/v1/mtn/payments/accounts/{accountId}/cash-out', [
    'uses' => 'Payment\CashIn\MTN\CashOutController@create',
    'middleware' => 'auth',
    'as'=>'payment-gateway/MTNCashIn'
]);

$router->get('/v1/mtn/payments/transactions/{transactionId}', [
    'uses' => 'Payment\CashIn\MTN\TransactionsController@fetch',
    'middleware' => 'auth',
    'as'=>'payment-gateway/MTNRequestToPayGetStatus'
]);

$router->get('/v1/mtn/payments/update-wallet-accounts', [
    'uses' => 'Payment\CashIn\MTN\TransactionsController@updateWalletAccounts',
]);

$router->put('/v1/mtn/payments/callback', [
    'uses' => 'Payment\CashIn\MTN\IndexController@callback',
]);


$router->get('/v1/stripe/payments/form/{amount}/{currency}/{accountId}/{userId}', 'Payment\Stripe\PaymentIntentController@form');
$router->get('/v1/mtn/payments/form/{amount}/{currency}/{accountId}/{userId}', 'Payment\CashIn\MTN\IndexController@form');



