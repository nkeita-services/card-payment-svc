@extends('paypal.layouts.master')

@section('title')  Checkout @endsection

@section('head')
    <link rel="shortcut icon" type="image/x-icon" href="https://www.paypalobjects.com/webstatic/icon/favicon.ico">
@endsection


@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
            width: 30%;
        }

    </style>
@endsection

@section('body')
    <body>
            <div class="flex-center position-ref full-height">
                <div class="content">
                    <form method="POST" id="paypal-payment"
                          action="{{route('payment-gateway/PaypalPaymentExecutionCreateExecution',
                          ['accountId' => $accountId]
                          )}}"
                    >
                        <input type="hidden" name="currency" value="{{$currency}}">
                        <input type="hidden" name="amount" value="{{$amount}}">
                        <input type="hidden" name="accountId" value="{{$accountId}}">
                        <input type="hidden" name="description" value="{{$description}}">
                        <input type="hidden" name="originator[originatorType]" value="User">
                        <input type="hidden" name="originator[originatorId]" value="{{$userId}}">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" > {{ money_format('%i', $amount) }}  Pay with Paypal </button>
                    </form>
                </div>
            </div>
    </body>
@endsection
