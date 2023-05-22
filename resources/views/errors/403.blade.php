<!DOCTYPE html>
<html class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(auth()->user()->hasPermissionTo('can use account'))
        <title> {{session()->get('locale') === 'en' ? 'Page dont exist' : 'Nemlétező oldal' }} | PupilPay</title>
    @else
        <title> {{session()->get('locale') === 'en' ? 'Please wait for activation' : 'Please wait for activation HU' }} | PupilPay</title>
    @endif
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">
</head>

<body class="h-full">
@if(auth()->user()->hasPermissionTo('can use account'))
    <a href="/{{auth()->user()->role}}/dashboard/" class="flex items-center m-3 w-fit">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
        </svg>
        <h1 class="text-indigo-600 font-bold">
            {{session()->get('locale') === 'en' ? 'Return back' : 'Vissza'}}
        </h1>
    </a>
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div>
                <img class="mx-auto h-16 w-auto" src="<?php echo asset('img/pupilpay-black-color.svg') ?>"
                     alt="PupilPay" />
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">{{session()->get('locale') === 'en' ? 'Page dont exist' : 'Ez az oldal nem létezik' }} </h2>
                <p class="mt-2 text-center text-lg font-semibold text-gray-700">
                    {{session()->get('locale') === 'en' ? 'Page you are searching for do not exist at the moment, please try again later, or return on auth/dashboard pages' :
    'A keresett oldal nem létezik, kérjük probáld meg később, vagy térj vissza az irányítópultba' }}.
                </p>
                <p class="mt-2 text-center text-xs text-gray-600">
                    {{session()->get('locale') === 'en' ? ' Try opening your link again, or check if you entered everything correctly'
    : 'Próbáld meg mégegyszer megnyitni a linket, vagy ellenőrizd hogy helyesen írtad-e le az URL-t' }}.
                </p>
            </div>
        </div>
    </div>
@else
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div>
                <img class="mx-auto h-16 w-auto" src="<?php echo asset('img/pupilpay-black-color.svg') ?>"
                     alt="PupilPay" />
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">{{session()->get('locale') === 'en' ? 'Please wait until your account will be activated' :
 'Please wait until your account will be activated HU' }} </h2>
                <p class="mt-2 text-center text-lg font-semibold text-gray-700">
                    {{session()->get('locale') === 'en' ? 'Please wait or try to refresh your page' :
    'Please wait or try to refresh your page HU' }}.
                </p>
                <p class="mt-2 text-center text-xs text-gray-600">
                    {{session()->get('locale') === 'en' ? 'Some text here'
    : 'Some text here HU' }}.
                </p>
            </div>
            <div class="flex items-center justify-center">
                <form action="{{ route('logout') }}" method="GET">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">{{session()->get('locale') === 'en' ? 'Log out' : 'Kijelentkezés'}}</button>
                </form>
            </div>
        </div>
    </div>
@endif
</body>

</html>
