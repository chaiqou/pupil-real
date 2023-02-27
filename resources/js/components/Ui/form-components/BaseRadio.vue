<template>
  <slot>
    <template class="flex flex-wrap justify-between">
      <h1 class="mb-2 font-semibold text-gray-700">{{ propName }}</h1>
    </template>
  </slot>
  <label
    class="relative flex cursor-pointer flex-col rounded-tl-md rounded-tr-md border p-4 focus:outline-none md:grid md:grid-cols-3 md:pl-4 md:pr-6"
  >
    <span class="flex items-center text-sm">
      <input
        type="radio"
        :name="propName"
        :value="propValue"
        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
      />
      <span class="ml-3 font-medium">{{ propName }}</span>
    </span>
  </label>
</template>

<script setup>
defineProps({
  propName: {
    type: String,
    required: true,
  },
  propValue: {
    type: String,
    required: true,
  },
});
</script>
