<!DOCTYPE html>
<html class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Two Factor Authentication | PupilPay</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">
</head>


<body class="h-full">
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
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
            <div class="flex items-center justify-center">
                <form action="{{ route('2fa.resend') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="group relative flex items-center w-fit justify-center rounded-md border border-transparent text-sm font-medium text-indigo-600 hover:text-indigo-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Resend Code
                    </button>
                </form>
            </div>
            <form name="twoFaForm" class="mt-8 space-y-6" action="{{ route('2fa.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="remember" value="true" />
                <div class="-space-y-px rounded-md shadow-sm border border-gray-200 p-4">
                    <div class="row-start-2 grid grid-cols-6">
                        <input onkeyup="stepForward(1)" onkeydown="stepBack(event, 1)" onclick="resetValue(1)"
                            id="sc-1"
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="*" maxlength="1" name="two_factor_code[0]" oninput="checkInputLengths()" required/>
                        <input onkeyup="stepForward(2)" onkeydown="stepBack(event, 2)" onclick="resetValue(2)"
                            id="sc-2"
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="*" maxlength="1" name="two_factor_code[1]" oninput="checkInputLengths()" required/>
                        <input onkeyup="stepForward(3)" onkeydown="stepBack(event, 3)" onclick="resetValue(3)"
                            id="sc-3"
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="*" maxlength="1" name="two_factor_code[2]" oninput="checkInputLengths()" required/>
                        <input onkeyup="stepForward(4)" onkeydown="stepBack(event, 4)" onclick="resetValue(4)"
                            id="sc-4"
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="*" maxlength="1" name="two_factor_code[3]" oninput="checkInputLengths()" required/>
                        <input onkeyup="stepForward(5)" onkeydown="stepBack(event, 5)" onclick="resetValue(5)"
                            id="sc-5"
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="*" maxlength="1" name="two_factor_code[4]" oninput="checkInputLengths()" required/>
                        <input onkeyup="stepForward(6)" onkeydown="stepBack(event, 6)" onclick="resetValue(6)"
                            id="sc-6"
                            class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl"
                            placeholder="*" maxlength="1" name="two_factor_code[5]" oninput="checkInputLengths()" required/>
                    </div>
                </div>

                <div>
                    <x-alerts.error type="error" ></x-alerts.error>
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
            <div class="flex items-center justify-center">
                <form action="{{ route('logout') }}" method="GET">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Log
                        out</button>
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
    <script>
        window.onload = function() {
            document.getElementById("sc-1").focus();
        };

        //Check if input lengths is true, so we can start auto submit
        function checkInputLengths() {
            const inputOne = document.getElementById('sc-1').value.length;
            const inputTwo = document.getElementById('sc-2').value.length;
            const inputThree = document.getElementById('sc-3').value.length;
            const inputFour = document.getElementById('sc-4').value.length;
            const inputFive = document.getElementById('sc-5').value.length;
            const inputSix = document.getElementById('sc-6').value.length;

            if (inputOne && inputTwo && inputThree && inputFour && inputFive && inputSix)
            {
               window.onInputTimeout = setTimeout(function() {
                    document.twoFaForm.submit();
                }, 2000)
            }
        }

        //Listen to paste event
        document.addEventListener('paste', function (event) {
            const inputs = document.querySelectorAll('input[id^="sc-"]');
            const verificationCode = [];
            const inputsFilled = Array.from(inputs).every((input) => input.value);

            if (!inputsFilled) {
                // Only allow paste if all inputs are empty
                const pastedValue = event.clipboardData.getData("text");
                if (pastedValue.length === 6 && /^\d+$/.test(pastedValue)) {
                    const codeArray = pastedValue.split("");
                    for (let i = 0; i < codeArray.length; i++) {
                        verificationCode[i] = codeArray[i];
                        inputs[i].value = codeArray[i];
                    }
                }
                document.getElementById("sc-6").focus();
                // Check if all inputs are filled
                if (verificationCode.every((code) => code)) {
                    window.onPasteTimeout = setTimeout(() => {
                        onSubmit();
                    }, 2300);
                } else {
                    document.getElementById("sc-1").focus();
                }
                event.preventDefault();
            }
        });

        function resetValue(i) {
            //Reset sc-n if it equals or is higher than i
            clearTimeout(window.onInputTimeout);
            clearTimeout(window.onPasteTimeout);
            for (let j = i; j <= 6; j++) {
                document.getElementById("sc-" + j).value = "";
            }
        }

        function stepForward(i) {
            if (document.getElementById('sc-' + i).value.length !== 1) {
                document.getElementById('sc-' + i).value = ''
            } else {
                if (i !== 6) {
                    document.getElementById('sc-' + i).value = document.getElementById('sc-' + i).value.toUpperCase()
                    document.getElementById('sc-' + (i + 1)).focus()
                }
            }
        }

        function stepBack(evtobj, i) {
            // If sender pressed backspace, reset sc-i and focus on sc-i-1
            clearTimeout(window.onPasteTimeout);
            clearTimeout(window.onInputTimeout);
            if (evtobj.keyCode === 8) {
                const currentInput = document.getElementById("sc-" + i);
                currentInput.value = "";
                if (i > 1) {
                    const prevInput = document.getElementById("sc-" + (i - 1));
                    if (prevInput) {
                        prevInput.focus();
                    }
                }
            }
        }
    </script>
</body>

</html>
