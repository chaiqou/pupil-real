<template>
    <div class="bg-gray-900 md:w-full md:h-full">
      <div class="mx-auto max-w-7xl py-12 px-4 sm:px-6 lg:px-8 lg:py-24">
        <div class="space-y-12">
          <div class="space-y-5 sm:space-y-4 md:max-w-xl lg:max-w-3xl xl:max-w-none">
           <img class="mx-left h-12 w-auto"
           src="https://pupilpay.hu/resc/img/pupilpay-white-white.svg" alt="white-logo" >
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Welcome Nikoloz!</h2>
            <p class="text-xl text-gray-300">Select a student dashboard.</p>
          </div>
          <ul role="list" class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 lg:gap-8">
            <li v-for="person in students" :key="person.first_name" class="rounded-lg bg-gray-800 py-10 px-6 text-center xl:px-10 xl:text-left">
                <a href="#" class="group flex flex-col items-center gap-2">
      <span class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-gray-500">
        <span class="text-xl font-medium leading-none text-white">{{ person['first_name'].slice(0,2).toUpperCase() }}</span>
      </span>
      <p class="text-gray-500 group-hover:text-gray-300">{{ person['first_name']  + ' ' + person['last_name'] }}</p>
    </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </template>

  <script setup>


defineProps({
    students: {
        type: Array,
        required: true
    }
});
  </script>
