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
</script>
