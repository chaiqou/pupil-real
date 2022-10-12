<head>
    <link rel="stylesheet" href="<?php echo asset('css/app.css') ?>" type="text/css">
</head>

<body>

<main class="flex justify-center mt-48 flex-col items-center">

   <div class="border-[0.1rem] text-gray-500 font-bold text-xl border-gray-300 flex px-4 py-4 rounded-md">
       <article class="flex items-center">
           <div class="mr-3 p-5 rounded-full border-2 border-gray-400 w-4 h-4 justify-center items-center flex">
               <p>01</p>
           </div>
           <div>
               <p>Setup Account</p>
           </div>
       </article>
       <article class="flex mx-16 items-center">
           <div class="mr-3 p-5 rounded-full border-2 border-gray-400 w-4 h-4 justify-center items-center flex">
               <p>02</p>
           </div>
           <div>
               <p>Personal Form</p>
           </div>
       </article>
       <article class="flex items-center">
           <div class="mr-3 p-5 rounded-full border-2 border-gray-400 w-4 h-4 justify-center items-center flex">
               <p>03</p>
           </div>
           <div>
               <p>Verify Account</p>
           </div>
       </article>
   </div>

        <div class="flex mt-12 flex-col items-center ">
            <div class="w-80">
                <img src="{{asset('/img/pupilpay-black-color.svg')}}" alt="pupilpay-black-color"/>
            </div>
            <h1 class="text-4xl font-extrabold mt-7">Set up your account</h1>
        </div>

    <div class="mt-12 p-7 rounded-md">
        <form id="form" method="POST" action="{{route('setup.account_submit', ['uniqueID' => $uniqueID])}}" class="flex flex-col">
            @csrf
            <div>
                <label for="email">Email Address</label>
                <div class="p-2 mt-2 bg-gray-50 rounded-md border-gray-400 border-[0.01rem]">
                    <input id="email" value="{{old('username')}}" name="email" type="text" class="border-none focus:ring-0 bg-gray-50 w-[44.7rem]"/>
                </div>
                @error('email')
                <p class="mt-2 text-red-500">{{$message}}</p>
                @enderror

            </div>
            <div class="mt-4">
                <label for="password"">Password</label>
                <div class="p-2 mt-2 bg-gray-50 rounded-md border-gray-400 border-[0.01rem]">
                    <input id="password" name="password" type="password" class="border-none focus:ring-0 bg-gray-50 w-[44.7rem]"/>
                </div>
                @error('password')
                <p class="mt-2 text-red-500">{{$message}}</p>
                @enderror
            </div>
            <button type="submit" class="bg-[#3341FF] text-white p-3 mt-8 text-xl rounded-md">Sign up</button>
        </form>
    </div>

</main>

</body>


