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
            <img src="{{asset('/img/pupilpay-black-color.svg')}}"/>
        </div>
        <h1 class="text-4xl font-extrabold mt-7">Fill out your personal info</h1>
    </div>

    <div class="mt-12 w-[47.3rem] border-t-[1px] border-b-[3px] border-l-[1.5px] border-r-[1.5px]  border-opacity-10 shadow-md border-gray-400 p-7 rounded-md">
       <div>
           <h1 class="text-2xl">Personal Information</h1>
           <p class="text-gray-600 mt-2 mb-7">
               Use a permanent address where you can receive mail
           </p>
       </div>
        <form>
    <div class="flex items-center justify-between">
        <div class="mt-4">
            <label>Last name</label>
            <div class="p-2 rounded-md bg-gray-50 border-gray-400 border-[0.01rem]">
                <input class="bg-gray-50 outline-none w-[13rem]"/>
            </div>
        </div>
        <div class="mt-4">
            <label>First name</label>
            <div class="p-2 bg-gray-50 rounded-md border-gray-400 border-[0.01rem]">
                <input class="bg-gray-50 outline-none w-[13rem]"/>
            </div>
        </div>
        <div class="mt-4">
            <label>Middle name</label>
            <div class="p-2 bg-gray-50 rounded-md border-gray-400 border-[0.01rem]">
                <input class="bg-gray-50 outline-none w-[13rem]"/>
            </div>
        </div>
    </div>



           <div class="mt-4">
               <label for="countries" class="block mb-2 text-sm font-medium text-gray-900">Country / Region</label>

                  <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg outline-none block w-[33rem] p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                      <option selected>Hungary</option>
                      <option value="US">United States</option>
                      <option value="CA">Canada</option>
                      <option value="FR">France</option>
                      <option value="DE">Germany</option>
                  </select>

           </div>

            <div class="mt-4">
                <label>Street address</label>
                <div class="p-2 rounded-md border-gray-400 bg-gray-50 border-[0.01rem]">
                    <input type="select" class="bg-gray-50 outline-none w-[13rem]"/>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="mt-4">
                    <label>City</label>
                    <div class="p-2 rounded-md bg-gray-50 border-gray-400 border-[0.01rem]">
                        <input class="bg-gray-50 outline-none w-[13rem]"/>
                    </div>
                </div>
                <div class="mt-4">
                    <label>State / Province</label>
                    <div class="p-2 bg-gray-50 rounded-md border-gray-400 border-[0.01rem]">
                        <input class="bg-gray-50 outline-none w-[13rem]"/>
                    </div>
                </div>
                <div class="mt-4">
                    <label>Middle name</label>
                    <div class="p-2 bg-gray-50 rounded-md border-gray-400 border-[0.01rem]">
                        <input class="bg-gray-50 outline-none w-[13rem]"/>
                    </div>
                </div>
            </div>

        </form>
    </div>

</main>
</body>
