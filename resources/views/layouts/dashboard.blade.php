<!DOCTYPE html>
<html class="h-full bg-gray-50" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">

</head>

<body class="h-full">
    <div id="app">
        <div class="relative z-40 md:hidden" role="dialog" aria-modal="true">
            <dashboard-navigation-mobile :role="{{ json_encode($role) }}" :current="{{ json_encode($current) }}"
                                         :navigation="{{ json_encode($navigation) }}" :students="{{json_encode($students)}}" :student="{{json_encode($student)}}"/>
        </div>
        <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
            <div class="flex min-h-0 flex-1 flex-col border-r border-gray-200 bg-white">
                <div class="flex flex-1 flex-col overflow-y-auto pt-5 pb-4">
                    <div class="flex flex-shrink-0 items-center px-4">
                        <img class="h-8 w-auto" src="https://pupilpay.hu/resc/img/pupilpay-black-color.svg"
                            alt="Your Company" />
                    </div>
                    <dashboard-navigation :current="{{ json_encode($current) }}"
                        :navigation="{{ json_encode($navigation) }}" />
                </div>
                <div class="flex flex-shrink-0 border-t border-gray-200 p-4">
                    <switch-account :role="{{ json_encode($role) }}" :student="{{ json_encode($student)}}" :students="{{json_encode($students)}}"/>
                </div>
            </div>
        </div>
        <div class="flex flex-1 flex-col md:pl-64">
            <div class="sticky top-0 z-10 bg-gray-100 pl-1 pt-1 sm:pl-3 sm:pt-3 md:hidden">
                <div class="flex items-center flex-row-reverse justify-between">
                    <img class="h-8 w-auto mr-5" src="https://pupilpay.hu/resc/img/pupilpay-black-color.svg"
                        alt="Your Company" />
                    <navigation-menu-button />
                </div>

            </div>

            @yield('content')


        </div>
    </div>
</body>

</html>
<script src="{{ mix('js/app.js') }}"></script>
