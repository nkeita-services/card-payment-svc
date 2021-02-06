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

$router->post('/v1/mtn/payments/accounts/{accountId}/cash-in', [
    'uses' => 'Payment\CashIn\MTN\CashInController@create',
    'middleware' => 'auth',
    'as'=>'payment-gateway/MTNCashIn',
    'groups'=> [
        'root',
        'admin'
    ]
]);

$router->get('/v1/mtn/payments/transactions/{transactionId}/cash-in', [
    'uses' => 'Payment\CashIn\MTN\TransactionsController@fetch',
    'middleware' => 'auth',
    'as'=>'payment-gateway/MTNRequestToPayGetStatus'
]);

$router->get('/v1/mtn/payments/update-wallet-accounts/cash-in', [
    'uses' => 'Payment\CashIn\MTN\TransactionsController@updateWalletAccounts',
]);

$router->put('/v1/mtn/payments/callback', [
    'uses' => 'Payment\CashIn\MTN\IndexController@callback',
]);



$router->post('/v1/paypal/payments/execute/{accountId}', [
    'uses' => 'Payment\Paypal\PaymentExecutionController@createOrder',
    'middleware' => 'auth',
    'as'=>'payment-gateway/PaypalPaymentExecutionCreateExecution'
]);

$router->post('/v1/paypal/payments/paypalwebhook', [
    'uses' => 'Payment\Paypal\PaymentExecutionController@webHook',
    'as'=>'payment-gateway/paypalWebHook'
]);


$router->get('/v1/stripe/payments/form/{amount}/{currency}/{accountId}/{userId}', 'Payment\Stripe\PaymentIntentController@form');
$router->get('/v1/mtn/payments/form/{amount}/{currency}/{accountId}/{userId}', 'Payment\CashIn\MTN\IndexController@form');

$router->post('/v1/mtn/payments/accounts/{accountId}/cash-out', [
    'uses' => 'Payment\CashOut\MTN\CashOutController@create',
    'middleware' => 'auth',
    'as'=>'payment-gateway/MTNCashOut',
    'groups'=> [
        'root',
        'admin'
    ]
]);

$router->get('/v1/mtn/payments/transactions/{transactionId}/cash-out', [
    'uses' => 'Payment\CashOut\MTN\TransactionsController@fetch',
    'middleware' => 'auth',
    'as'=>'payment-gateway/MTNTransferGetStatus'
]);

$router->get('/v1/mtn/payments/update-wallet-accounts/cash-out', [
    'uses' => 'Payment\CashOut\MTN\TransactionsController@updateWalletAccounts',
]);



$router->get('/v1/paypal/payments/form/{amount}/{currency}/{accountId}/{userId}', 'Payment\Paypal\PaymentExecutionController@form');



$router->get('/v1/paypal/payments/sucess', [
    'uses' =>  'Payment\Paypal\PaymentExecutionController@success',
    'as'=>'return'
]);


$router->get('/v1/paypal/payments/cancel', [
    'uses' =>  'Payment\Paypal\PaymentExecutionController@cancel',
    'as'=>'cancel'
]);

$router->get('/v1/cash-ins/eventType/{eventType}/eventId/{eventId}', [
    'uses' => 'Payment\CashIn\FetchCashInRequestController@fetchFromEventTypeAndEventId',
    'middleware' => 'auth',
    'as'=>'payment-gateway/CashInRead',
    'groups'=> [
        'root',
        'admin'
    ]
]);

$router->get('/v1/cash-ins/events/topUp/{transactionId}/fees', [
    'uses' => 'Payment\CashIn\GetTopUpFeesController@fetchFromTransactionId',
    'middleware' => 'auth',
    'as'=>'payment-gateway/CashInRead',
    'groups'=> [
        'root',
        'admin'
    ]
]);

$router->post('/v1/alipay/collecting-qr-code/payments/execute/{accountId}', [
    'uses' => 'Payment\AliPayWechatPay\Alipay\CollectingQRCodeController@collectingQRCode',
   // 'middleware' => 'auth',
    'as'=>'payment-gateway/AlipayCollectingQRCode'
]);

$router->post('/v1/alipay/wap-pay/payments/execute/{accountId}', [
    'uses' => 'Payment\AliPayWechatPay\Alipay\WapPaymentController@create',
    //'middleware' => 'auth',
    'as'=>'payment-gateway/AlipayWapPayment'
]);

$router->get('/v1/alipay/payments/notify', [
    'uses' =>  'Payment\AliPayWechatPay\Alipay\NotificationController@notify',
    'as'=>'AlipayNotify'
]);


$router->post('/v1/wechatpay/collecting-qr-code/payments/execute/{accountId}', [
    'uses' => 'Payment\AliPayWechatPay\Wechatpay\CollectingQRCodeController@collectingQRCode',
    //'middleware' => 'auth',
    'as'=>'payment-gateway/WechatPayCollectingQRCode'
]);

$router->post('/v1/wechatpay/account-pay/payments/execute/{accountId}', [
    'uses' => 'Payment\AliPayWechatPay\Wechatpay\AccountPayController@create',
    //'middleware' => 'auth',
    'as'=>'payment-gateway/AlipayAccountPay'
]);

$router->post('/v1/wechatpay/app-pay/payments/execute/{accountId}', [
    'uses' => 'Payment\AliPayWechatPay\Wechatpay\AppPayController@create',
    //'middleware' => 'auth',
    'as'=>'payment-gateway/AlipayAppPay'
]);

$router->get('/v1/wechatpay/payments/notify', [
    'uses' =>  'Payment\AliPayWechatPay\Wechatpay\NotificationController@notify',
    'as'=>'WechatpayNotify'
]);

// Business collecting QRCODE
$router->post('/v1/alipay-wechatpay/payments/execute/{accountId}/payment-type/{paymentMean}', [
    'uses' => 'Payment\AliPayWechatPay\BusinessCollectingQRCodeController@collectingQRCode',
   // 'middleware' => 'auth',
    'as'=>'payment-gateway/AlipayWechatpay'
]);




