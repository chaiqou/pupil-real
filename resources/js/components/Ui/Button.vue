<template>
  <button
    :type="type"
    class="mt-4 flex w-full justify-center rounded-md bg-indigo-700 px-4 py-2 text-base font-medium text-white"
  >
    <p class="text-center"><slot></slot> {{ text }}</p>
  </button>
</template>

<script setup>
defineProps({
  text: {
    type: String,
    required: false,
    default: "Submit",
  },
  type: {
    type: String,
    required: false,
    default: "button",
  },
});
</script>
