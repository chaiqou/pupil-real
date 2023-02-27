<template>
  <div
    class="fixed z-50 flex min-h-screen w-screen flex-col items-center justify-center bg-black/50"
  >
    <div
      class="absolute w-full max-w-lg rounded-lg bg-white px-6 py-10 shadow-2xl md:right-1/3 xl:right-[45%]"
    >
      <template class="flex flex-wrap justify-between border-b border-gray-200">
        <h1 class="mb-2 font-semibold text-gray-700">Lunch name</h1>
      </template>
      <slot></slot>
    </div>
  </div>
</template>

<script setup></script>
