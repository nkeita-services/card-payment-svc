<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
*/

namespace App\Http\Controllers\Payment\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Payment\Stripe\PaymentIntent\Service\PaymentIntentServiceInterface;
use Log;
use Payment\Account\Service\AccountServiceInterface;
use Stripe\Event;


/**
 * Description of PaymentIntentController
 *
 * @author mohamedkeita
 */
class PaymentIntentController extends Controller
{
    /**
     *
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * @var PaymentIntentServiceInterface
     */
    private $paymentIntentService;

    /**
     * PaymentIntentController constructor.
     * @param AccountServiceInterface $accountService
     * @param PaymentIntentServiceInterface $paymentIntentService
     */
    public function __construct(
        AccountServiceInterface $accountService,
        PaymentIntentServiceInterface $paymentIntentService
    )
    {
        $this->accountService = $accountService;
        $this->paymentIntentService = $paymentIntentService;
    }


    public function create(Request $request)
    {

        $intent = $this->paymentIntentService->create(
            $request->json()->get('amount'),
            $request->json()->get('currency'),
            $request->json()->get('accountId')
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'PaymentIntent' => [
                    'clientSecret' => $intent->getClientSecret(),
                    'publishableKey' => $intent->getPublishableKey()
                ]
            ]
        ]);
    }

    public function form(float $amount, string $currency, string $accountId)
    {

        return view(
            'stripe/collect_card_details',
            [
                'amount' => $amount,
                'currency' => $currency,
                'accountId' => $accountId,
                'accessToken' =>  app('WalletGatewayOauthClient')->accessToken()
            ]);
    }

    public function webhook(Request $request)
    {
        try {
            $event = Event::constructFrom(
                $request->json()->all()
            );
        } catch (\UnexpectedValueException $e) {

            return response()->json([
                'status' => 'failure',
            ]);

        }

        $intent = $this
            ->paymentIntentService
            ->storeEvent(
                //'pi_1GUgoiI7cAZaA1PNoDshcDne_secret_RhN5E2hVytvvjDVdubSX4hFK5',
                $event->data->object->client_secret,
                $event->type,
                $event->data->object->toArray()
            );

        if('payment_intent.succeeded' == $event->type){
            $this->accountService->topUpFromPaymentIntent(
                $intent
            );
        }

        return response()->json(
            [
                'status' => 'success',
            ], 200);
    }
}
