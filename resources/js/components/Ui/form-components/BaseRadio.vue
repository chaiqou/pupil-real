<template>
  <label
    class="relative mb-2 flex cursor-pointer flex-col whitespace-nowrap rounded-lg border p-4 focus:outline-none md:grid md:grid-cols-3 md:pl-4 md:pr-6"
  >
    <span class="flex items-center text-sm">
      <Field :name="name" type="radio" :value="menu" />
      <span class="ml-3 font-medium">{{ menu }}</span>
    </span>
  </label>

  <ErrorMessage
    class="text-center font-sans text-base font-medium text-red-500 subpixel-antialiased"
    :name="name"
  />
</template>

<script setup>
import { Field, ErrorMessage } from "vee-validate";

defineProps({
  name: {
    type: String,
    required: true,
  },
  menu: {
    type: String,
    required: true,
  },
});
</script>
