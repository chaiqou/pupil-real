<template>
    <div class="border-b border-gray-200">
        <AnimatedPlaceholder />
        <div
            class="flex flex-wrap space-y-4 w-full justify-between my-4 sm:space-y-0 sm:flex-nowrap sm:space-x-12"
        >
            <AnimatedPlaceholder
                class="items-center p-4 w-full rounded-md border border-gray-300 bg-white text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            />
            <AnimatedPlaceholder />
        </div>
    </div>
</template>

<script setup>
import AnimatedPlaceholder from "./AnimatedPlaceholder.vue";
</script>
