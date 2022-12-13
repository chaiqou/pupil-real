<!DOCTYPE html>
<html class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email | PupilPay</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">
</head>

<body class="h-full">
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8 flex items-center justify-center flex-col" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
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
                                <span class="ml-4 text-sm font-medium text-gray-900">Set up Account</span>
                            </span>
                        </div>
                    </li>

                    <li class="relative md:flex md:flex-1">
                        <div class="flex items-center px-6 py-4 text-sm font-medium" aria-current="step">
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-600">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <span class="ml-4 text-sm font-medium text-gray-900">Personal Form</span>
                        </div>

                    </li>

                    <li class="relative md:flex md:flex-1">
                        <div class="group flex items-center">
                            <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-indigo-600">
                                    <span class="text-indigo-600">03</span>
                                </span>
                                <span class="ml-4 text-sm font-medium text-indigo-600">Verify Account</span>
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div>
                <img class="mx-auto h-16 w-auto" src="<?php echo asset('img/pupilpay-black-color.svg') ?>" alt="PupilPay" />
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Verify your email</h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Enter the
                    <span class="font-medium text-indigo-600 hover:text-indigo-500">6-digit</span>
                    verification code sent to {{ $email }}.
                </p>
                <p class="mt-2 text-center text-xs text-gray-600">
                    If you can't find the email in a few minutes, check your spam folder.
                </p>
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
                <form id="form" name="inviteTwoFaForm" method="POST" action="{{route('merchant-verify.email_submit',['uniqueID'=>$uniqueID])}}" class="mt-8 space-y-6 w-full">
                    @csrf
                    <div class="-space-y-px rounded-md shadow-md p-4">
                        <div class="row-start-2 grid grid-cols-6">
                            <input type="text" onkeyup="stepForward(1)" onkeydown="stepBack(event, 1)" onclick="resetValue(1)" id="sc-1" name="code_each[1]" oninput="checkInputLengths()" class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl" placeholder="1" value=""/>
                            <input type="text" onkeyup="stepForward(2)" onkeydown="stepBack(event, 2)" onclick="resetValue(2)" id="sc-2" name="code_each[2]" oninput="checkInputLengths()" class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl" placeholder="2" value=""/>
                            <input type="text" onkeyup="stepForward(3)" onkeydown="stepBack(event, 3)" onclick="resetValue(3)" id="sc-3" name="code_each[3]" oninput="checkInputLengths()" class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl" placeholder="3" value=""/>
                            <input type="text" onkeyup="stepForward(4)" onkeydown="stepBack(event, 4)" onclick="resetValue(4)" id="sc-4" name="code_each[4]" oninput="checkInputLengths()" class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl" placeholder="4" value=""/>
                            <input type="text" onkeyup="stepForward(5)" onkeydown="stepBack(event, 5)" onclick="resetValue(5)" id="sc-5" name="code_each[5]" oninput="checkInputLengths()" class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl" placeholder="5" value=""/>
                            <input type="text" onkeyup="stepForward(6)" onkeydown="stepBack(event, 6)" onclick="resetValue(6)" id="sc-6" name="code_each[6]" oninput="checkInputLengths()" class="bg-gray-50 uppercase h-14 w-10 border mx-2 rounded-lg flex items-center text-center font-mono text-xl" placeholder="6" value=""/>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
              <!-- Heroicon name: mini/identification -->
              <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M1 6a3 3 0 013-3h12a3 3 0 013 3v8a3 3 0 01-3 3H4a3 3 0 01-3-3V6zm4 1.5a2 2 0 114 0 2 2 0 01-4 0zm2 3a4 4 0 00-3.665 2.395.75.75 0 00.416 1A8.98 8.98 0 007 14.5a8.98 8.98 0 003.249-.604.75.75 0 00.416-1.001A4.001 4.001 0 007 10.5zm5-3.75a.75.75 0 01.75-.75h2.5a.75.75 0 010 1.5h-2.5a.75.75 0 01-.75-.75zm0 6.5a.75.75 0 01.75-.75h2.5a.75.75 0 010 1.5h-2.5a.75.75 0 01-.75-.75zm.75-4a.75.75 0 000 1.5h2.5a.75.75 0 000-1.5h-2.5z" clip-rule="evenodd" />
              </svg>

            </span>
                            Verify
                        </button>
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
                  document.inviteTwoFaForm.submit();
              }, 2000)
          }
      }

        //Listen to paste event
        document.addEventListener('paste', function(e) {
            var pastedText = e.clipboardData.getData('text/plain');
            //wait a second, then paste it
            if (pastedText.length === 6) {
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
               window.onPasteTimeout = setTimeout(function() {
                    document.inviteTwoFaForm.submit();
                }, 2300)
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
            //If sender pressed backspace, reset sc-i and focus on sc-i-1
            clearTimeout(window.onPasteTimeout);
            clearTimeout(window.onInputTimeout);
            if (evtobj.keyCode === 8) {
                document.getElementById('sc-' + i).value = ''
                document.getElementById('sc-' + (i - 1)).focus()
            }
        }
    </script>
</body>

</html>
