<template>
  <div>
    <label class="text-md flex whitespace-normal font-bold text-gray-600"
      >{{ label }}
    </label>
    <Field
      :name="name"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      :type="type"
      :min="min"
      :max="max"
      :placeholder="placeholder"
      :as="inputType"
      v-bind="$attrs"
      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
    />
    <span class="mt-2 whitespace-nowrap text-sm text-red-500">
      <ErrorMessage :name="name" />
    </span>
  </div>
</template>

<script setup>
import { Field, ErrorMessage } from 'vee-validate';

const props = defineProps({
  name: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    required: false,
  },
  placeholder: {
    type: String,
    required: false,
  },
  type: {
    type: String,
    required: false,
    default: 'text',
  },
  min: {
    type: [Number, String],
    required: false,
  },
  max: {
    type: [Number, String],
    required: false,
  },
  inputType: {
    type: String,
    required: false,
    default: 'input',
  },
  modelValue: {
    type: [String, Number, Array],
    default: '',
  },
});
</script>
