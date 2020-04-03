<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controller\Payment\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

 

/**
 * Description of PaymentIntentController
 *
 * @author mohamedkeita
 */
class PaymentIntentController extends Controller{
    
    public function create(Request $request){
        var_dump($request->json());exit;
        
    }
    
    public function form(float $amount, string $currency){
        var_dump($amount,$currency);exit;
        
    }
}
