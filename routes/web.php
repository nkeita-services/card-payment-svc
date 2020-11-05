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

$router->get('/docs', function () use ($router) {
    return redirect('/documentation/api/rest/swagger/index.html');
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

$router->post('/v1/payments/accounts/{accountId}/cash-in/mtn', [
    'uses' => 'Payment\CashIn\MTN\IndexController@create',
    'middleware' => 'auth',
    'as'=>'payment-gateway/MTNCashIn'
]);



$router->post('/v1/paypal/payments/execute/{accountId}', [
    'uses' => 'Payment\Paypal\PaymentExecutionController@createOrder',
    'as'=>'payment-gateway/PaypalPaymentExecutionCreateExecution'
]);

$router->post('/paypal/payments/paypalwebhook', [
    'uses' => 'Payment\Paypal\PaymentExecutionController@webHook',
    'as'=>'payment-gateway/paypalWebHook'
]);


$router->get('/v1/stripe/payments/form/{amount}/{currency}/{accountId}/{userId}', 'Payment\Stripe\PaymentIntentController@form');
$router->get('/v1/mtn/payments/form/{amount}/{currency}/{accountId}/{userId}', 'Payment\CashIn\MTN\IndexController@form');


$router->get('/v1/paypal/payments/form/{amount}/{currency}/{accountId}/{userId}', 'Payment\Paypal\PaymentExecutionController@form');



$router->get('/v1/paypal/payments/sucess', [
    'uses' =>  'Payment\Paypal\PaymentExecutionController@success',
    'as'=>'return'
]);


$router->get('/v1/paypal/payments/cancel', [
    'uses' =>  'Payment\Paypal\PaymentExecutionController@cancel',
    'as'=>'cancel'
]);


