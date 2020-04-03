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

 

/**
 * Description of PaymentIntentController
 *
 * @author mohamedkeita
 */
class PaymentIntentController extends Controller{
    
    public function create(Request $request){
        Stripe::setApiKey('sk_test_Uz7JHXYgI9Ih0b6oxf9wCyK300e95hcUlt');

        $intent = PaymentIntent::create([
          'amount' => $request->json()->get('amount'),
          'currency' => $request->json()->get('currency'),
          // Verify your integration in this guide by including this parameter
          'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);
        
        return response()->json([
            'status'=>'success',
            'data'=>[
                'PaymentIntent'=>[
                    'clientSecret'=> $intent->client_secret
                ]
            ]
        ]);
    }
    
    public function form(float $amount, string $currency){
        
        return view('stripe/collect_card_details');
    }
}
