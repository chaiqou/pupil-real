<template>
  <template class="flex flex-wrap justify-between">
    <h1 class="mb-2 font-semibold text-gray-700">
      {{ `${date}` }}
    </h1>
  </template>
  <div v-if="name.menu_type == 'choices'">
    <template v-for="menu in menu_name" :key="menu">
      <BaseRadio
        v-model="choicesValue"
        :menu-name="menu"
        :label="menu"
        name="choices"
      />
    </template>
  </div>
  <div v-if="name.menu_type == 'fixed'">
    <BaseRadio :menu-name="name" name="fixed" :label="name.menu_name" />
  </div>
</template>

<script setup>
import { ref } from "vue";
import BaseRadio from "@/components/Ui/form-components/BaseRadio.vue";

defineProps({
  name: {
    type: Object,
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
    type: [Array, String],
  },
});

const choicesValue = ref("");
</script>
