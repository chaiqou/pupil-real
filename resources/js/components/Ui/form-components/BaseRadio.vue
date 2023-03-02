<template>
  <slot>
    <template class="flex flex-wrap justify-between">
      <h1 class="mb-2 font-semibold text-gray-700">
        {{ `${date}` }}
      </h1>
    </template>
  </slot>
  <div v-if="name.menu_type == 'choices'">
    <template v-for="menu in menu_name" :key="menu">
      <label
        :for="menu"
        class="relative mb-2 flex cursor-pointer flex-col whitespace-nowrap rounded-lg border p-4 focus:outline-none md:grid md:grid-cols-3 md:pl-4 md:pr-6"
      >
        <span class="flex items-center text-sm">
          <input
            type="radio"
            :name="menu"
            :value="menu"
            :id="menu"
            v-model="radioValue"
            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
          />
          <span class="ml-3 font-medium">{{ menu }}</span>
        </span>
      </label>
    </template>
  </div>
  <div v-if="name.menu_type == 'fixed'">
    <label
      class="relative flex cursor-pointer flex-col rounded-lg border p-4 focus:outline-none md:grid md:grid-cols-3 md:pl-4 md:pr-6"
    >
      <span class="flex items-center text-sm">
        <input
          type="radio"
          :name="name"
          :value="value"
          :id="name"
          v-model="radioValue"
          class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
        />
        <span class="ml-3 font-medium">{{ name.menu_name }}</span>
      </span>
    </label>
  </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
  name: {
    type: String,
    required: true,
  },
  value: {
    type: [Boolean, String],
    required: true,
  },
  date: {
    type: String,
    required: true,
  },
  menu_name: {
    type: Array,
  },
});

const radioValue = ref(props.value);
</script>
