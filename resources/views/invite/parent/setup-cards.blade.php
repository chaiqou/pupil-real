<!DOCTYPE html>
<html class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Set up Cards | PupilPay</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">
</head>

<body class="h-full">
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8 flex items-center justify-center flex-col" data-sal="slide-up" data-sal-duration="500" data-sal-delay="200">
            <nav aria-label="Progress">
                <ol role="list" class="divide-y divide-gray-300 rounded-md border border-gray-300 md:flex md:divide-y-0 md:w-fit">
                    <li class="relative md:flex md:flex-1">
                        <div class="group flex w-full items-center">
                            <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-600">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="ml-4 text-sm font-medium text-gray-900">Setup Account</span>
                            </span>
                        </div>
                    </li>

                    <li class="relative md:flex md:flex-1">
                        <div class="group flex w-full items-center">
                            <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-600">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="ml-4 text-sm font-medium text-gray-900">Personal Form</span>
                            </span>
                        </div>
                    </li>

                    <li class="relative md:flex md:flex-1">
                        <div class="group flex w-full items-center">
                            <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-indigo-600">
                                    <span class="text-indigo-600">03</span>
                                </span>
                                <span class="ml-4 text-sm font-medium text-indigo-600">Setup Cards</span>
                            </span>
                        </div>
                    </li>

                    <li class="relative md:flex md:flex-1">
                        <div class="group flex items-center">
                            <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300">
                                    <span class="text-gray-500">04</span>
                                </span>
                                <span class="ml-4 text-sm font-medium text-gray-500">Verify Account</span>
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div>
                <img class="mx-auto h-16 w-auto" src="<?php echo asset('img/pupilpay-black-color.svg') ?>" alt="PupilPay" />
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Setup your cards</h2>
            </div>
            @error('*')
            <div class="rounded-md bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">{{ $message }}</h3>
                    </div>
                </div>
            </div>
            @enderror
        <div class="w-full">
            <form id="form" method="POST" action="{{route('parent-setup.cards_submit',['uniqueID'=>$uniqueID])}}" class="mt-8 space-y-6">
                @csrf
               <div class="flex w-full bg-black justify-between">
                   <button name="user_response" class="bg-green-500 hover:bg-green-600 px-3 py-1.5 text-white rounded-md" value="save_card">Save card for faster checkout</button>
                   <button name="user_response" class="bg-red-500 hover:bg-red-700 px-3 py-1.5 text-white rounded-md" value="dont_save_card">Don't save card</button>
               </div>
            </form>
        </div>
        </div>
    </div>
    <script src="{{asset('js/sal.js')}}"></script>
    <script>
        sal({
            threshold: 0,
            once: true,
        });
    </script>
</body>

</html>