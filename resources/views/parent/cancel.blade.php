<!DOCTYPE html>
<html class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stripe cancelled | PupilPay</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">
</head>

<body class="h-full flex justify-center items-center ">
    <div id="app">
    <parent-calendar></parent-calendar>
    </div>

        <div class="bg-white px-12 py-10 shadow-xl sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10">
                <section>
                    <h2 class="text-lg font-medium text-gray-900">
                        Order summary
                    </h2>
                     <p class="mt-2 text-sm text-gray-500 lg:mb-12">
                   order cancelled from {{ \Carbon\Carbon::parse($order->start_date)->format('Y-m-d') }} - {{ \Carbon\Carbon::parse($order->end_date)->format('Y-m-d') }}
                    </p>
                </section>
            <div class="relative block w-full mt-4 rounded-lg border-2 border-red-300 bg-red-100 p-12 text-center hover:border-red-400">
            <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="mx-auto h-12 w-12 text-red-400"
    >
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
        />
    </svg>
          <span class="mt-2 block text-sm font-medium text-red-700">Failed payment</span>
          <span class="mt-2 block text-sm font-semibold text-red-700 ">Your payment has failed, or has been cancelled. The lunch order has not been placedo</span>
        </div>
        </div>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </body>
</html>
