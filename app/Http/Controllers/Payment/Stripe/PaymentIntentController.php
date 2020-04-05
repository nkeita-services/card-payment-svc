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
use Stripe\PaymentIntent;
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
                'accountId' => $accountId
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

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $intent = $this
                    ->paymentIntentService
                    ->storeEvent(
                        $event->data->object->client_secret,
                        $event->type,
                        $event->data->object->toArray()
                    );

                $this->accountService->topUp(
                    'eeee',
                    $intent->getAccountId(),
                    ['eee'],
                    $intent->getAmount()
                );
                break;
            case 'payment_method.attached':
                $paymentMethod = $event->data->object; // contains a StripePaymentMethod

                break;
            // ... handle other event types
            default:
                // Unexpected event type
                http_response_code(400);
                exit();
        }

        return response()->json(
            [
                'status' => 'success',
            ], 200);
    }
}
