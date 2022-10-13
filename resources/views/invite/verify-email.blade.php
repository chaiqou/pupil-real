<head>
    <link rel="stylesheet" href="<?php echo asset('css/app.css') ?>" type="text/css">
</head>

<body>
<main class="flex justify-center mt-48 flex-col items-center">

    <div class="border-[0.1rem] text-gray-500 font-bold text-xl border-gray-300 flex px-4 py-4 rounded-md">
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
        <p class="text-4xl font-bold text-center my-4">Check *email* for a verification code</p>
        <form id="form" method="POST" action="{{route('setup.account_submit', ['uniqueID' => $uniqueID])}}" class="flex flex-col">
            @csrf
            <div>
                <label for="code">Verification code</label>
                <div class="p-2 mt-2 bg-gray-50 rounded-md border-gray-400 border-[0.01rem] justify-around flex">
                    <div><input id="code" value="{{old('code')}}" name="code" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/></div>
                    <div><input id="code" value="{{old('code')}}" name="code" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/></div>
                    <div><input id="code" value="{{old('code')}}" name="code" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/></div>
                    <div><input id="code" value="{{old('code')}}" name="code" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/></div>
                    <div><input id="code" value="{{old('code')}}" name="code" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/></div>
                    <div><input id="code" value="{{old('code')}}" name="code" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/></div>
                    <div><input id="code" value="{{old('code')}}" name="code" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/></div>
                    <div><input id="code" value="{{old('code')}}" name="code" type="text" class="border-2 border-gray-400 focus:ring-0 bg-gray-50 p-2 w-[2rem] text-center rounded-md"/></div>
                </div>
                @error('code')
                <p class="mt-2 text-red-500">{{$message}}</p>
                @enderror
            </div>
            <button type="submit" class="bg-[#3341FF] text-white p-3 mt-8 text-xl rounded-md">Verify</button>
        </form>
    </div>

</main>

</body>
