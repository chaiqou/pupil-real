<!DOCTYPE html>
<html class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{auth()->user()->language === 'en' ? 'Successful Payment' : 'Sikeres fizetés'}} | PupilPay</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">
</head>

<body class="flex justify-center items-center">
<div class="flex flex-col">
    <a class="flex items-center m-3" href="{{config('app.url')}}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
        </svg>
        <h1 class="text-indigo-600 font-bold">{{auth()->user()->language === 'en' ? 'Return back' : 'Vissza'}}</h1>
    </a>
    <div class="hidden sm:block" id="app">
        <parent-calendar :stripe-days="{{$order}}"></parent-calendar>
    </div>
</div>
    <div class="bg-white mt-40 px-12 py-10 md:shadow-xl sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10">
        <section>
            <h2 class="text-lg font-medium text-gray-900">
                {{auth()->user()->language === 'en' ? 'Order summary' : 'Rendelés összesítése'}}
            </h2>
            <p class="mt-2 text-sm text-gray-500 font-medium lg:mb-12">
                {{ $order->lunch_title}} | {{ \Carbon\Carbon::parse($order->start_date)->format('Y-m-d') }} - {{ \Carbon\Carbon::parse($order->end_date)->format('Y-m-d') }}
            </p>
        </section>
        <div class="w-full mt-4 rounded-lg border-2 border-green-600 !bg-green-200 hover:border-green-400 hover:shadow-2xl p-12 text-center ">
            <svg class="mx-auto h-12 w-12 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>

            <span class="mt-2 block text-md font-semibold text-green-700">
               {{auth()->user()->language === 'en' ? 'Successful payment' : 'Sikeres fizetés'}}</span>
            <span class="mt-2 block text-sm font-medium text-green-800 ">
                  {{auth()->user()->language === 'en' ? 'Your payment has been successful and the lunch order has been placed. You will shortly receive your invoice in your email' : 'A fizetés sikeres volt, és az ebéd rendelés le lett adva. A számlát hamarosan az email fiókjában találja.'}}.</span>
        </div>
    </div>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</body>

</html>
