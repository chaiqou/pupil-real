<template>
  <label
    class="relative mb-2 flex cursor-pointer flex-col whitespace-nowrap rounded-lg border p-4 focus:outline-none md:grid md:grid-cols-3 md:pl-4 md:pr-6"
  >
    <span class="flex items-center text-sm">
      <input
        type="radio"
        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
        :value="modelValue"
        :name="label"
        :id="label"
        :checked="name"
        @change="$emit('update:modelValue', name)"
      />

      <span class="ml-3 font-medium">{{ name }}</span>
    </span>
  </label>
</template>

<script setup>
defineProps({
  modelValue: {
    type: String,
  },
  name: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
});
</script>
