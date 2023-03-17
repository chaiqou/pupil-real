<template>
  <label
    class="relative mb-2 flex cursor-pointer flex-col whitespace-nowrap rounded-lg border p-4 focus:outline-none md:grid md:grid-cols-3 md:pl-4 md:pr-6"
  >
    <span class="flex items-center text-sm">
      <Field
        :name="name"
        type="radio"
        :value="value"
        :checked="selectedvalue === value"
        @click="select"
        class="form-checkbox checked:foucs:border-indigo-700 checked:border-indigo-700 checked:bg-indigo-700 checked:outline-indigo-500 checked:hover:bg-indigo-700 checked:focus:bg-indigo-700"
      />
      <span class="ml-3 font-medium">{{ value }}</span>
    </span>
  </label>
</template>

<script setup>
import { Field } from "vee-validate";
import { ref, onMounted, defineProps, defineEmits } from "vue";

const emits = defineEmits(["update:modelValue"]);

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

let selectedvalue = ref(null);

function select() {
  selectedvalue.value = props.value;
  emits("update:modelValue", props.value);
}

onMounted(() => {
  if (selectedvalue.value === null) {
    selectedvalue.value = props.value;
    emits("update:modelValue", props.value);
  }
});
</script>
