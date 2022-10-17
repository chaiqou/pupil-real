<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo asset('css/app.css') ?>" type="text/css">
</head>

<body>
<main class="flex justify-center mt-12 md:mt-48 flex-col items-center">

    <div class="border-[0.1rem] text-gray-500 font-bold text-xl border-gray-300 px-4 py-4 rounded-md hidden md:flex">
        <article class="flex  items-center text-[#3341FF]">
                <div class="mr-3 p-5 rounded-full border-[1px] border-[#3341FF] w-4 h-4 justify-center items-center flex">
                    <div class="z-40">
                        <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>

                    <div class="bg-[#3341FF] text-white absolute z-30 rounded-full absolute p-5"></div>
                </div>

            <div>
                <p>Setup Account</p>
            </div>
        </article>
        <article class="flex mx-16 items-center text-[#3341FF]">
            <div class="mr-3 p-5 rounded-full border-[1px] border-[#3341FF] w-4 h-4 justify-center items-center flex">
                <div class="z-40">
                    <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>

                <div class="bg-[#3341FF] text-white absolute z-30 rounded-full absolute p-5"></div>
            </div>
            <div>
                <p>Personal Form</p>
            </div>
        </article>
        <article class="flex items-center text-[#3341FF]">
            <div class="mr-3 p-5 rounded-full border-2 border-[#3341FF] w-4 h-4 justify-center items-center flex">
                <p>03</p>
            </div>
            <div>
                <p>Verify Email</p>
            </div>
        </article>
    </div>

    <div class="flex mt-12 flex-col items-center ">
        <div class="w-80">
            <img src="{{asset('/img/pupilpay-black-color.svg')}}" alt="pupilpay-black-color"/>
        </div>
        <h1 class="text-4xl font-extrabold mt-7">Verify email</h1>
    </div>

    <div class="mt-12 border-t-[1px] border-b-[3px] border-l-[1.5px] border-r-[1.5px]  border-opacity-10 shadow-md border-gray-400 p-7 rounded-md">
        <p class="md:text-4xl font-bold text-center my-2">Check {{$email}}</p>
        <p class="md:text-4xl font-bold text-center my-2">for a verification code</p>
        <form id="form" method="POST" action="{{route('verify.email_submit', ['uniqueID' => $uniqueID])}}" class="flex flex-col">
            @csrf
            <div>
                <label for="code">Verification code</label>
                <div class="p-2 mt-2 justify-around flex">
                    <div>
                        <input  onkeyup="stepForward(1)" onkeydown="stepBack(event, 1)" onclick="resetValue(1)" id="sc-1" name="code_each[1]"  type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/>
                    </div>
                    <div>
                        <input  onkeyup="stepForward(2)" onkeydown="stepBack(event, 2)" onclick="resetValue(2)" id="sc-2" name="code_each[2]" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/>
                    </div>
                    <div>
                        <input  onkeyup="stepForward(3)" onkeydown="stepBack(event, 3)" onclick="resetValue(3)" id="sc-3" name="code_each[3]" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/>
                    </div>
                    <div>
                        <input  onkeyup="stepForward(4)" onkeydown="stepBack(event, 4)" onclick="resetValue(4)" id="sc-4" name="code_each[4]" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/>
                    </div>
                    <div>
                        <input  onkeyup="stepForward(5)" onkeydown="stepBack(event, 5)" onclick="resetValue(5)" id="sc-5" name="code_each[5]" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/>
                    </div>
                    <div>
                        <input  onkeyup="stepForward(6)" onkeydown="stepBack(event, 6)" onclick="resetValue(6)" id="sc-6" name="code_each[6]" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/>
                    </div>
                    <div>
                        <input  onkeyup="stepForward(7)" onkeydown="stepBack(event, 7)" onclick="resetValue(7)" id="sc-7" name="code_each[7]" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/>
                    </div>
                    <div>
                        <input  onkeyup="stepForward(8)" onkeydown="stepBack(event, 8)" onclick="resetValue(8)" id="sc-8" name="code_each[8]" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/>
                    </div>
                </div>
                <div class="flex justify-center mt-2">
                    <input name="code" hidden/>
                    @error('code')
                    <p class="text-red-500">  {{$message}} </p>
                    @enderror
                    @error('code_each.*')
                    <p class="text-red-500">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <button type="submit" class="bg-[#3341FF] text-white p-3 mt-8 text-xl rounded-md">Verify</button>
        </form>
    </div>

</main>

<script>
    window.onload = function() {
        document.getElementById("sc-1").focus();
    };

    //Listen to paste event
    document.addEventListener('paste', function(e) {
        var pastedText = e.clipboardData.getData('text/plain');
        //wait a second, then paste it
        if (pastedText.length == 8) {
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
                sc = document.getElementById("sc-7");
                sc.value = pastedText.substring(6, 7);
                sc = document.getElementById("sc-8");
                sc.value = pastedText.substring(7, 8);
            }, 300);
        }
    });
    function resetValue(i) {
        //Reset sc-n if it equals or is higher than i
        for (let j = i; j <= 8; j++) {
            document.getElementById("sc-" + j).value = "";
        }
    }
    function stepForward(i) {
        if (document.getElementById('sc-' + i).value.length != 1) {
            document.getElementById('sc-' + i).value = ''
        } else {
            if (i != 8) {
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
