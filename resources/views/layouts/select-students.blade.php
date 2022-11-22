<!DOCTYPE html>
<html class="h-screen bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Select Student | PupilPay</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">

</head>

<body class="h-full">
    <div class="bg-gray-900 w-full h-full">
        <div class="mx-auto max-w-7xl py-12 px-4 sm:px-6 lg:px-8 lg:py-24">
            <div class="space-y-12">
                <div class="space-y-5 sm:space-y-4 md:max-w-xl lg:max-w-3xl xl:max-w-none">
                    <img class="mx-left h-12 w-auto" src="https://pupilpay.hu/resc/img/pupilpay-white-white.svg"
                        alt="white-logo">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Welcome Nikoloz!</h2>
                    <p class="text-xl text-gray-300">Select a student dashboard.</p>
                </div>
                <ul role="list"
                    class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 lg:gap-8">
                    @foreach ($students as $student)
                        <li class="rounded-lg bg-gray-800 py-10 px-6 text-center xl:px-10 xl:text-left">
                            <a href="{{ route('parent.dashboard', ['student_id' => $student->id]) }}"
                                class="group flex flex-col items-center gap-2">
                                <span
                                    class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-gray-500">
                                    <span
                                        class="text-xl font-medium leading-none text-white">{{ Str::upper(Str::substr($student['first_name'], 0, 2)) }}</span>
                                </span>
                                <p class="text-gray-500 mt-2 group-hover:text-gray-300">
                                    {{ $student['first_name'] . ' ' . $student['last_name'] }}</p>
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div class="flex items-center justify-center">
            <form action="{{ route('logout') }}" method="GET">
                @csrf
                <button type="submit"
                    class="inline-flex items-center mb-10 rounded-md h-12 w-36 text-center px-10 py-4 bg-gray-800  text-md font-medium leading-4 text-white shadow-sm hover:bg-gray-900 focus:outline-none">Log
                    out</button>
            </form>
        </div>
    </div>

</body>

</html>
@vite(['resources/css/app.css', 'resources/js/app.js'])
