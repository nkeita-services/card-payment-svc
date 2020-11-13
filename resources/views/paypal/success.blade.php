@extends('paypal.layouts.master')

@section('title') Success @endsection

@section('body')
    <body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="alert alert-success" role="alert">
                Payment was successfull. The payment success page goes here!
            </div>
        </div>
    </div>
    </body>
@endsection
