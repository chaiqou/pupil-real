<html class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Two Factor Authentication | PupilPay</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">
</head>


<body class="h-full">
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div>
                <img class="mx-auto h-12 w-auto" src="https://pupilpay.hu/resc/img/pupilpay-black-color.svg"
                    alt="PupilPay" />
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Two-factor authentication
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Enter the
                    <span href="#" class="font-medium text-indigo-600 hover:text-indigo-500">6-digit</span>
                    verification code sent to your email address
                </p>
                <p class="mt-2 text-center text-xs text-gray-600">
                    If you can't find the email in a few minutes, check your spam folder.
                </p>
            </div>
            <form class="mt-8 space-y-6" action="#" method="POST">
                <input type="hidden" name="remember" value="true" />
                <div class="-space-y-px rounded-md shadow-md p-4">
                    <div class="row-start-2 grid grid-cols-6">
                        <input
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="1" value=""></input>
                        <input
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="2" value=""></input>
                        <input
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="3" value=""></input>
                        <input
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="4" value=""></input>
                        <input
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="5" value=""></input>
                        <input
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="6" value=""></input>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <!-- Heroicon name: mini/lock-closed -->
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
