<!DOCTYPE html>
<html class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal form | PupilPay</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">
</head>

<body class="h-full">
<div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-xl space-y-8" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
        <nav aria-label="Progress">
            <ol role="list" class="divide-y divide-gray-300 rounded-md border border-gray-300 md:flex md:divide-y-0">
                <li class="relative md:flex md:flex-1">
                    <div class="group flex w-full md:justify-center">
                            <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-600">
                                    <!-- Heroicon name: solid/check -->
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="ml-4 text-sm font-medium text-gray-900">Set up Student</span>
                            </span>
                    </div>
                </li>

                <li class="relative md:flex md:flex-1 justify-center">
                    <div class="flex items-center px-6 py-4 text-sm font-medium" aria-current="step">
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-indigo-600">
                                <span class="text-indigo-600">02</span>
                            </span>
                        <span class="ml-4 text-sm font-medium text-indigo-600">Confirm</span>
                    </div>

                </li>
            </ol>
        </nav>
        <div class="flex flex-col items-center justify-center">
            <div class="mb-8 text-xl">
                <p>Confirm student creation</p>
            </div>
            <div class="md:w-[30rem]">
                <img class="bg-gray-200 mx-auto rounded-md shadow-2xl" src="{{asset('img/pupilpay-with-lines.svg')}}" alt="PupilPay" />
                <div>
                <p class="mt-10 text-sm">
                    Are you sure you’re ready to create a new student and request a card?
                </p>

                  <div class="flex justify-center items-center justify-around mt-10">
                      <div>
                          <form method="POST" action="{{route('parent.create-student-verify_submit', ['student_id' => request()->student_id])}}">
                              @csrf
                              <input type="hidden" value="confirm" name="value"/>
                              <button class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Confirm</button>
                          </form>
                      </div>

                      <div>
                          <form method="POST" action="{{route('parent.create-student-verify_submit', ['student_id' => request()->student_id])}}">
                              @csrf
                              <input type="hidden" value="cancel" name="value"/>
                              <button class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                          </form>
                      </div>
                  </div>

                </div>
            </div>
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

    </div>
</div>
<script src="<?php echo asset('js/sal.js') ?>"></script>
<script>
    sal({
        threshold: 0,
        once: true,
    });
</script>
</body>


</html>

