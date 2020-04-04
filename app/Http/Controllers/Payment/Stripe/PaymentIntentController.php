<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Payment\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Event;
use Log;
use MongoClient;
use MongoDB\Client;
use Payment\Account\Service\AccountServiceInterface ;
use Payment\Account\Service\AccountService;
 

/**
 * Description of PaymentIntentController
 *
 * @author mohamedkeita
 */
class PaymentIntentController extends Controller{
    
    /**
     *
     * @var AccountServiceInterface 
     */
    private $accountService;
    
    public function __construct(AccountService $accountService) {
        $this->accountService = $accountService;
    }


    public function create(Request $request){

        $mongoClient = new Client('mongodb+srv://wallet-account-user:ccKUENpgY2Bj0gly@cluster0-ydv8p.mongodb.net/wallet?authSource=admin');
        $collection = $mongoClient->selectCollection('wallet', 'payments');
        
        Stripe::setApiKey('sk_test_Uz7JHXYgI9Ih0b6oxf9wCyK300e95hcUlt');

        $intent = PaymentIntent::create([
          'amount' => $request->json()->get('amount'),
          'currency' => $request->json()->get('currency'),
          'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);
        
        $collection->insertOne(
            [
                'clientSecret'=>$intent->client_secret,
                'amount'=> $request->json()->get('amount'),
                'currency'=>$request->json()->get('currency'),
                'accountId'=>$request->json()->get('accountId')
            ]
        );
        return response()->json([
            'status'=>'success',
            'data'=>[
                'PaymentIntent'=>[
                    'clientSecret'=> $intent->client_secret,
                    'publishableKey'=> 'pk_test_muG8jSMNY9OyPOQFCN3JtYMx00w4hXalgG'
                ]
            ]
        ]);
    }
    
    public function form(float $amount, string $currency){
        
        return view('stripe/collect_card_details');
    }
    
    public function webhook(Request $request){
        $mongoClient = new Client('mongodb+srv://wallet-account-user:ccKUENpgY2Bj0gly@cluster0-ydv8p.mongodb.net/wallet?authSource=admin');
        $paymentIntentsCollection = $mongoClient->selectCollection('wallet', 'payment_intents');
        $paymentCollection = $mongoClient->selectCollection('wallet', 'payments');
        Stripe::setApiKey('sk_test_Uz7JHXYgI9Ih0b6oxf9wCyK300e95hcUlt');

        try {
            $event = \Stripe\Event::constructFrom(
                $request->json()->all()
            );
        } catch(\UnexpectedValueException $e) {
            
            return response()->json([
                'status'=>'failure',
            ]);
            
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                /**
                 * @var PaymentIntent
                 */
                $paymentIntent = $event->data->object;
                $document = $paymentCollection->findOne(
                        [
                            'clientSecret' => $paymentIntent->client_secret
                        ]
                );
                $paymentIntentsCollection->insertOne($paymentIntent->toArray());
                
                $this->accountService->topUp('eeee', $document->accountId, ['eee'], $paymentIntent->amount);
                break;
            case 'payment_method.attached':
                $paymentMethod = $event->data->object; // contains a StripePaymentMethod
                Log::info($paymentIntent);
                break;
            // ... handle other event types
            default:
                // Unexpected event type
                http_response_code(400);
                exit();
        }

        return response()->json(
            [
                'status'=>'success',
            ], 200);
    }
}
