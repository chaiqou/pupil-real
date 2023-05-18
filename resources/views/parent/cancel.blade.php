<!DOCTYPE html>
<html class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{auth()->user()->language==='en' ? 'Stripe cancelled' : 'Stripe cancelled HU'}} | PupilPay</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">
</head>

<body class="flex justify-center items-center">
<div class="flex flex-col">
    <a class="flex items-center m-3" href="{{config('app.url')}}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
        </svg>
        <h1 class="text-indigo-600 font-bold">@section('title')
                {{auth()->user()->language === 'en' ? 'Return back to' : 'Return back to HU'}}
            @endsection</h1>
        <img class="w-20 ml-1" src="<?php echo asset('img/pupilpay-black-color.svg') ?>" alt="PupilPay" />
    </a>

    <div class="hidden sm:block" id="app">
        <parent-calendar :stripe-days="{{$order}}"></parent-calendar>
    </div>
</div>
    <div class="bg-white mt-40 px-12 py-10 md:shadow-xl sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10">
        <section>
            <h2 class="text-lg font-medium text-gray-900">
                {{auth()->user()->language === 'en' ? 'Order summary' : 'Order summary HU'}}
            </h2>
            <p class="mt-2 text-sm text-gray-500 font-medium lg:mb-12">
                {{ $order->lunch_title}} | {{ \Carbon\Carbon::parse($order->start_date)->format('Y-m-d') }} - {{ \Carbon\Carbon::parse($order->end_date)->format('Y-m-d') }}
            </p>
        </section>
        <div class="w-full mt-4 rounded-lg border-2 border-red-600 !bg-red-200 hover:border-red-400 hover:shadow-2xl p-12 text-center ">
            <svg class="mx-auto h-12 w-12 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
            <span class="mt-2 block text-md font-semibold text-red-700">{{auth()->user()->language === 'en' ? 'Payment failed' : 'Payment failed HU'}}</span>
            <span class="mt-2 block text-sm font-medium text-red-600 ">
                {{auth()->user()->language === 'en' ? 'Your payment has failed, or has been cancelled. The lunch order has not been placed' : 'Your payment has failed, or has been cancelled. The lunch order has not been placed HU'}}.</span>
        </div>
    </div>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</body>

</html>
