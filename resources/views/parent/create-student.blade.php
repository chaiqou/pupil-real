<!DOCTYPE html>
<html class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{auth()->user()->language === 'en' ? 'Personal Form' : 'Personal Form HU'}} | PupilPay</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">
</head>

<body class="h-full">
 <a href="/parent/dashboard/" class="flex items-center m-3 w-fit">
     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
         <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
     </svg>
     <h1 class="text-indigo-600 font-bold">Return back to</h1>
     <img class="w-20 ml-1" src="<?php echo asset('img/pupilpay-black-color.svg') ?>" alt="PupilPay" />
 </a>
<div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-xl space-y-8">
        <nav aria-label="Progress">
            <ol role="list" class="divide-y divide-gray-300 rounded-md border border-gray-300 md:flex md:divide-y-0">
                <li class="relative md:flex md:flex-1 justify-center">
                    <div class="group flex items-center">
                            <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-indigo-600">
                                    <span class="text-indigo-600">01</span>
                                </span>
                                <span class="ml-4 text-sm font-medium text-indigo-600">
                                {{auth()->user()->language === 'en' ? 'Set up Student' : 'Set up Student HU'}}
                                </span>
                            </span>
                    </div>
                </li>

                <li class="justify-center relative md:flex md:flex-1">
                    <div class="flex items-center px-6 py-4 text-sm font-medium" aria-current="step">
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300">
                                <span class="text-gray-500">02</span>
                            </span>
                        <span class="ml-4 text-sm font-medium text-gray-500">
                            {{auth()->user()->language === 'en' ? 'Confirm' : 'Confirm HU'}}
                        </span>
                    </div>

                </li>
            </ol>
        </nav>
        <div>
            <img class="mx-auto h-16 w-auto" src="<?php echo asset('img/pupilpay-black-color.svg') ?>" alt="PupilPay" />
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">
                {{auth()->user()->language === 'en' ? 'Fill out your personal information' : 'Fill out your personal information HU'}}

            </h2>
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
        <form id="form" method="POST" action="{{route('parent.create-student_submit', ['user_id' => $user_id])}}" class="mt-8 space-y-6 w-full">
            @csrf
            <div class="bg-white p-8">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        {{auth()->user()->language === 'en' ? 'Personal Information' : 'Personal Information HU'}}

                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{auth()->user()->language === 'en' ? 'Use a permanent address where you can receive mail' : 'Use a permanent address where you can receive mail HU'}}.</p>
                </div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label for="last-name" class="block text-sm font-medium text-gray-700">
                            {{auth()->user()->language === 'en' ? 'Last name' : 'Last name HU'}}
                        </label>
                        <div class="mt-1">
                            <input type="text" value="{{old('last_name')}}" required name="last_name" id="last_name" autocomplete="given-name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="first-name" class="block text-sm font-medium text-gray-700">
                            {{auth()->user()->language === 'en' ? 'First name' : 'First name HU'}}
                        </label>
                        <div class="mt-1">
                            <input type="text" value="{{old('first_name')}}" required name="first_name" id="first_name" autocomplete="family-name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="middle-name" class="block text-sm font-medium text-gray-700">
                            {{auth()->user()->language === 'en' ? 'Middle name' : 'Middle name HU'}}
                        </label>
                        <div class="mt-1">
                            <input type="text" value="{{old('middle_name')}}" name="middle_name" id="middle_name" autocomplete="additional-name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="country" class="block text-sm font-medium text-gray-700">
                            {{auth()->user()->language === 'en' ? 'Country' : 'Country HU'}}</label>
                        <div class="mt-1">
                            <select id="country" value="{{old('country')}}" name="country" autocomplete="country-name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                             <x-country-options></x-country-options>
                            </select>
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="street_address" class="block text-sm font-medium text-gray-700">
                            {{auth()->user()->language === 'en' ? 'Street address' : 'Street address HU'}}</label>
                        <div class="mt-1">
                            <input value="{{old('street_address')}}" type="text" name="street_address" id="street_address" autocomplete="street-address" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="city" class="block text-sm font-medium text-gray-700">
                            {{auth()->user()->language === 'en' ? 'City' : 'City HU'}}</label>
                        <div class="mt-1">
                            <input type="text" value="{{old('city')}}" name="city" id="city" autocomplete="address-level2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="state" class="block text-sm font-medium text-gray-700">
                            {{auth()->user()->language === 'en' ? 'State / Province' : 'State / Province HU'}}</label>
                        <div class="mt-1">
                            <input type="text" value="{{old('state')}}" name="state" id="state" autocomplete="address-level1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="zip" class="block text-sm font-medium text-gray-700">
                            {{auth()->user()->language === 'en' ? 'ZIP / Postal code' : 'ZIP / Postal code HU'}}</label>
                        <div class="mt-1">
                            <input type="text" value="{{old('zip')}}" name="zip" id="zip" autocomplete="postal-code" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>
                <div class="pt-5">
                    <div class="flex justify-end">
                        <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            {{auth()->user()->language === 'en' ? 'Save' : 'Save HU'}}
                        </button>
                    </div>
                </div>
            </div>
        </form>


    </div>
</div>
</body>

</html>
