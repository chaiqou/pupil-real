<template>
  <template class="flex flex-wrap justify-between">
    <h1 class="mb-2 font-semibold text-gray-700">{{ lunchName }}</h1>
  </template>
  <label
    class="relative flex cursor-pointer flex-col rounded-tl-md rounded-tr-md border p-4 focus:outline-none md:grid md:grid-cols-3 md:pl-4 md:pr-6"
  >
    <span class="flex items-center text-sm">
      <input
        type="radio"
        :name="name"
        :value="lunchValue"
        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
      />
      <span class="ml-3 font-medium">{{ lunchName }}</span>
    </span>
  </label>
</template>

<script setup>
defineProps({
  name: {
    type: String,
    required: true,
    default: "first",
  },
  lunchName: {
    type: String,
    required: true,
    default: "Lunch",
  },
  lunchValue: {
    type: String,
    required: true,
    default: "Lunch",
  },
});
</script>
