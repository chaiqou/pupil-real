<!DOCTYPE html>
<html class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stripe successed | PupilPay</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">
</head>

<body class="h-full flex justify-center items-center">

        <div class="bg-white px-12 py-10 shadow-xl sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10">
                <section>
                    <h2 class="text-lg font-medium text-gray-900">
                        Order summary - Thanks {{ $customer->first_name }} {{ $customer->last_name }}
                    </h2>
                     <p class="mt-2 text-sm text-gray-500 font-medium lg:mb-12">
                  your order dates from {{ \Carbon\Carbon::parse($order->start_date)->format('Y-m-d') }} - {{ \Carbon\Carbon::parse($order->end_date)->format('Y-m-d') }}
                    </p>
                </section>
            <div class="w-full mt-4 rounded-lg border-2 border-green-600 !bg-green-300 hover:border-green-400 p-12 text-center ">
    <svg  class="mx-auto h-12 w-12 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
</svg>

          <span class="mt-2 block text-sm font-medium text-green-700">Successful payment</span>
          <span class="mt-2 block text-sm font-semibold text-green-800 ">You payment has been successful and the lunch order has been placed</span>
        </div>
        </div>


    </body>
</html>
