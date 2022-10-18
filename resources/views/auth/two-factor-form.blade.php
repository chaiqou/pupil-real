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
                    <span class="font-medium text-indigo-600 hover:text-indigo-500">6-digit</span>
                    verification code sent to your email address
                </p>
                <p class="mt-2 text-center text-xs text-gray-600">
                    If you can't find the email in a few minutes, check your spam folder.
                </p>
            </div>
            <div class='flex items-center space-x-8 justify-around'>
                <button type="button" name='two_factor_token' id='two_factor_token'
                    class="inline-flex items-center rounded-md border border-transparent bg-gray-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Resent code
                </button>
                <button type="button"
                    class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-10 py-3 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Log Out</button>

            </div>
            <form class="mt-8 space-y-6" action="/submit-two-factor-authentication" method="POST">
                @csrf
                <input type="hidden" name="remember" value="true" />
                <div class="-space-y-px rounded-md shadow-md p-4">
                    <div class="row-start-2 grid grid-cols-6">
                        <input onkeyup="stepForward(1)" onkeydown="stepBack(event, 1)" onclick="resetValue(1)"
                            id="sc-1"
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="1" maxlength="1" name="two_factor_token[0]" required></input>
                        <input onkeyup="stepForward(2)" onkeydown="stepBack(event, 2)" onclick="resetValue(2)"
                            id="sc-2"
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="2" maxlength="1" name="two_factor_token[1]" required></input>
                        <input onkeyup="stepForward(3)" onkeydown="stepBack(event, 3)" onclick="resetValue(3)"
                            id="sc-3"
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="3" maxlength="1" name="two_factor_token[2]" required></input>
                        <input onkeyup="stepForward(4)" onkeydown="stepBack(event, 4)" onclick="resetValue(4)"
                            id="sc-4"
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="4" maxlength="1" name="two_factor_token[3]" required></input>
                        <input onkeyup="stepForward(5)" onkeydown="stepBack(event, 5)" onclick="resetValue(5)"
                            id="sc-5"
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="5" maxlength="1" name="two_factor_token[4]" required></input>
                        <input onkeyup="stepForward(6)" onkeydown="stepBack(event, 6)" onclick="resetValue(6)"
                            id="sc-6"
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="6" maxlength="1" name="two_factor_token[5]" required></input>
                    </div>
                </div>

                <div>
                    <x-alerts.error type="error" />
                    <button type="submit"
                        class="group relative mt-4 flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
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
    <script>
        window.onload = function() {
            document.getElementById("sc-1").focus();
        };
        //Listen to paste event
        document.addEventListener('paste', function(e) {
            var pastedText = e.clipboardData.getData('text/plain');
            //wait a second, then paste it
            if (pastedText.length == 6) {
                setTimeout(function() {
                    var sc = document.getElementById("sc-1");
                    sc.value = pastedText.substring(0, 1);
                    sc = document.getElementById("sc-2");
                    sc.value = pastedText.substring(1, 2);
                    sc = document.getElementById("sc-3");
                    sc.value = pastedText.substring(2, 3);
                    sc = document.getElementById("sc-4");
                    sc.value = pastedText.substring(3, 4);
                    sc = document.getElementById("sc-5");
                    sc.value = pastedText.substring(4, 5);
                    sc = document.getElementById("sc-6");
                    sc.value = pastedText.substring(5, 6);
                }, 300);
            }
        });

        function resetValue(i) {
            //Reset sc-n if it equals or is higher than i
            for (let j = i; j <= 6; j++) {
                document.getElementById("sc-" + j).value = "";
            }
        }

        function stepForward(i) {
            if (document.getElementById('sc-' + i).value.length != 1) {
                document.getElementById('sc-' + i).value = ''
            } else {
                if (i != 6) {
                    document.getElementById('sc-' + i).value = document.getElementById('sc-' + i).value.toUpperCase()
                    document.getElementById('sc-' + (i + 1)).focus()
                }
            }
        }

        function stepBack(evtobj, i) {
            //If sender pressed backspace, reset sc-i and focus on sc-i-1
            if (evtobj.keyCode == 8) {
                document.getElementById('sc-' + i).value = ''
                document.getElementById('sc-' + (i - 1)).focus()
            }
        }
    </script>
</body>

</html>
