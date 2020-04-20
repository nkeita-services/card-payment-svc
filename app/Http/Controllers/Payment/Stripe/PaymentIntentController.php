<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
*/

namespace App\Http\Controllers\Payment\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Payment\CashIn\Transaction\CashInTransactionEntity;
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


    public function create(
        string $accountId,
        Request $request
    ){

        $transaction = $this->paymentIntentService->create(
            new CashInTransactionEntity(
                'STRIPE',
                null,
                $request->json()->get('amount'),
                $request->json()->get('currency'),
                $request->json()->get('description'),
                $accountId,
                $request->json()->get('originator'),
                'pending',
                time()
            )
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'CashIn' => [
                    'transactionId'=> $transaction->getTransactionId(),
                    'amount'=> $transaction->getAmount(),
                    'status'=> $transaction->getStatus(),
                    'extras' => $transaction->getExtras()
                ]
            ]
        ]);
    }

    public function form(
        float $amount,
        string $currency,
        string $accountId,
        string $userId
    ){

        return view(
            'stripe/collect_card_details',
            [
                'amount' => $amount,
                'currency' => $currency,
                'accountId' => $accountId,
                'userId' => $userId,
                'description' => 'Top Up',
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

        $transaction = $this
            ->paymentIntentService
            ->storeEvent(
                'pi_1GYtH4I7cAZaA1PNJs5AfaY2_secret_YbXig4ONJDxy7W2hsGSOx2n5A',
                //$event->data->object->client_secret,
                $event->type,
                $event->data->object->toArray()
            );


        if('payment_intent.succeeded' == $event->type){
            $this->accountService->topUpFromCashInTransaction(
                $transaction
            );
        }

        return response()->json(
            [
                'status' => 'success',
            ], 200);
    }
}
