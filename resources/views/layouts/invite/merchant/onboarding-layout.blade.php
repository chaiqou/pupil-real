<!DOCTYPE html>
<html class="h-full bg-gray-50" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">

</head>

<body class="h-full">
<div id="app">
    @if(View::hasSection('hide-language'))
        <!-- Do not render set-language component -->
    @else
        <div class="absolute top-0 right-0 mt-3 mr-4">
            <set-language :user-id="{{json_encode($user->id)}}"></set-language>
        </div>
    @endif
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8 flex items-center justify-center flex-col" data-sal="slide-up" data-sal-duration="500" data-sal-delay="200">
            @yield('content')
        </div>
    </div>
</div>
</body>

</html>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="<?php echo asset('js/sal.js') ?>"></script>
<script>
    sal({
        threshold: 0,
        once: true,
    });

    // We are getting the user param from the controller, and here we have checks to always have the same locale as we have in our DB
    window.language = "{{$user ? $user->language : null}}"
    if(!window.language) {
        localStorage.getItem("i18n") ? window.language = localStorage.getItem("i18n") : 'en';
    }
    // We save this language param into the localstorage, so after this our language changers start to work, other function of this
    // is into the useGlobalStore and i18n config
    localStorage.setItem("i18n", language);
</script>
