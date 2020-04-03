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
    return redirect('/documentation/api/rest/swagger/index.html');
});


$router->post('/v1/stripe/payments/intents', 'Payment\Stripe\PaymentIntentController@create');

$router->get('/v1/stripe/payments/form/{amount}/{currency}', 'Payment\Stripe\PaymentIntentController@form');
