<template>
  <label
    class="relative mb-2 flex cursor-pointer flex-col whitespace-nowrap rounded-lg border p-4 focus:outline-none md:grid md:grid-cols-3 md:pl-4 md:pr-6"
  >
    <span class="flex items-center text-sm">
      <Field :name="name" type="radio" :value="value" v-model="selectedvalue" />
      <span class="ml-3 font-medium">{{ value }}</span>
    </span>
  </label>

  <ErrorMessage
    class="text-center font-sans text-base font-medium text-red-500 subpixel-antialiased"
    :name="name"
  />
</template>

<script setup>
import { Field, ErrorMessage } from "vee-validate";
import { ref } from "vue";

const props = defineProps({
  name: {
    type: String,
    required: true,
  },
  value: {
    type: String,
    required: true,
  },
});

let selectedvalue = ref(props.value);
</script>
