<template>
  <div
    class="fixed z-50 flex min-h-screen w-screen flex-col items-center justify-center bg-black/50"
  >
    <div
      class="absolute w-full max-w-lg rounded-lg bg-white px-6 py-10 shadow-2xl md:right-1/3 xl:right-[45%]"
    >
      <template class="flex flex-wrap justify-between border-b border-gray-200">
        <AnimatedPlaceholder class="mb-2 w-full font-semibold text-gray-700" />
      </template>

      <div class="mt-4 border-b border-gray-200">
        <h2 class="mt-2 font-semibold text-gray-700">
          <AnimatedPlaceholder
            class="mb-2 w-full font-semibold text-gray-700"
          />
        </h2>
        <div
          class="my-4 flex w-full flex-wrap justify-between space-y-4 sm:flex-nowrap sm:space-y-0 sm:space-x-12"
        >
          <AnimatedPlaceholder
            class="mb-2 w-full font-semibold text-gray-700"
          />
          <AnimatedPlaceholder
            class="mb-2 w-full font-semibold text-gray-700"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import AnimatedPlaceholder from '@/components/Ui/AnimatedPlaceholder.vue';
</script>
