<!DOCTYPE html>
<html class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{session()->get('locale') === 'en' ? 'Page dont exist' : 'Page dont exist HU' }} | PupilPay</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">
</head>

<body class="h-full">
            <a class="flex items-center m-3" href="{{config('app.url')}}">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
    </svg>
    <h1 class="text-indigo-600 font-bold">Return back to</h1>
    <img class="w-20 ml-1" src="<?php echo asset('img/pupilpay-black-color.svg') ?>" alt="PupilPay" />
</a>
<div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div>
            <img class="mx-auto h-16 w-auto" src="<?php echo asset('img/pupilpay-black-color.svg') ?>"
                 alt="PupilPay" />
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">{{session()->get('locale') === 'en' ? 'Page dont exist' : 'Page dont exist HU' }}</h2>
            <p class="mt-2 text-center text-lg font-semibold text-gray-700">
                {{session()->get('locale') === 'en' ? 'Page you are searching for do not exist at the moment, please try again later, or return on auth/dashboard pages'
 : 'Page you are searching for do not exist at the moment, please try again later, or return on auth/dashboard pages HU' }}.
            </p>
            <p class="mt-2 text-center text-xs text-gray-600">
                {{session()->get('locale') === 'en' ? ' Try opening your link again, or check if you entered everything correctly'
: 'Try opening your link again, or check if you entered everything correctly HU' }}.
            </p>
        </div>

    </div>
</div>
</body>

</html>
