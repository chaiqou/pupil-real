<template>
  <label
    class="relative mb-2 flex cursor-pointer flex-col whitespace-nowrap rounded-lg border p-4 focus:outline-none md:grid md:grid-cols-3 md:pl-4 md:pr-6"
  >
    <span class="flex items-center text-sm">
      <input
        type="radio"
        :value="modelValue"
        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
        :name="name"
        :id="menuName"
      />

      <span class="ml-3 font-medium">{{ label }}</span>
    </span>
  </label>
</template>

<script setup>
defineProps({
  modelValue: {
    type: [String, Boolean],
    default: "",
  },
  menuName: {
    type: [String, Object],
  },
  name: {
    type: String,
  },
  label: {
    type: String,
  },
});
</script>
